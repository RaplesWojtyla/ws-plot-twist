from numpy.core.defchararray import strip
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from bs4 import BeautifulSoup
import time


def scrape_film_details(driver, film_url):
    """
    Fungsi untuk scrape data dari halaman detail film
    """
    driver.get(film_url)
    time.sleep(10)  # Tunggu agar halaman detail film termuat

    soup = BeautifulSoup(driver.page_source, 'html.parser')

    # Mengambil data film
    title = soup.find('h1').get_text(strip=True) if soup.find('h1') else "N/A"
    # director = driver.find_element(By.CSS_SELECTOR, "div[id='cast'] > div.persons > div.person > div.data > div.name > a").text if driver.find_element(By.CSS_SELECTOR, "div[id='cast'] > div.persons > div.person > div.data > div.name > a") else "N/A"
    director_sect = soup.find("div", id="cast")
    director = director_sect.find("meta", itemprop="name")['content']
    release_date = soup.find('span', {'class': 'date'}).get_text(strip=True) if soup.find('span',{'class': 'date'}) else "N/A"
    country_elements = driver.find_elements(By.CSS_SELECTOR, "div.extra > span.country")
    country = country_elements[0].text if country_elements else "N/A"
    div_genre = soup.find('div', class_='sgeneros')
    genres = [a.get_text(strip=True) for a in div_genre.find_all('a')] if div_genre else "N/A"

    sinopsis_elements = driver.find_elements(By.CSS_SELECTOR, "div[itemprop='description'] > p")
    sinopsis = sinopsis_elements[0].text if sinopsis_elements else "N/A"

    rating = driver.find_element(By.CSS_SELECTOR, "div.starstruck-rating > span").text if driver.find_element(
        By.CSS_SELECTOR, "div.starstruck-rating > span") else "N/A"

    duration_elements = driver.find_elements(By.CSS_SELECTOR, "div.extra > span.runtime")
    duration = duration_elements[0].text if duration_elements else "N/A"

    image_url = soup.find('div', {'class': 'poster'}).find('img')['src'] if soup.find('div', {
        'class': 'poster'}) and soup.find('div', {'class': 'poster'}).find('img') else "N/A"

    return {
        'Title': title,
        'Director': director,
        'Release Date': release_date,
        'Country': country,
        'Genres': genres,
        'Sinopsis': sinopsis,
        'Rating': rating,
        'Duration': duration,
        'Image URL': image_url
    }


i = 2400


def scrape_page(driver, rdf_file):
    """
    Fungsi untuk scrape data film dari halaman utama
    """

    global i
    soup = BeautifulSoup(driver.page_source, 'html.parser')
    # Temukan semua elemen <article> yang sesuai
    film_links = soup.find_all('article', class_='item movies')
    urls = []

    # Filter artikel yang tidak mengandung "Featured" di dalam elemen div
    for article in film_links:
        poster_div = article.find('div', class_='poster')
        if not poster_div or 'Featured' in poster_div.text:  # Skip jika ada "Featured"
            continue

        # Ambil elemen <a> di dalam poster div
        link_tag = poster_div.find('a')
        if link_tag:
            href = link_tag.get('href')
            urls.append(href)

    unique_urls = []

    for url in urls:
        if url not in unique_urls:
            unique_urls.append(url)

    # print(unique_urls)
    # print(len(unique_urls))
    # j = 1
    for url in unique_urls:
        print(f"Scraping film: {url}")
        film_data = scrape_film_details(driver, url)

        # Menulis data ke dalam file RDF
        rdf_file.write(f':Film{i} a :Film ;\n')
        rdf_file.write(f'    :hasTitle "{film_data["Title"]}" ;\n')
        rdf_file.write(f'    :hasDirector "{film_data["Director"]}" ;\n')
        rdf_file.write(f'    :hasReleaseDate "{film_data["Release Date"]}" ;\n')
        rdf_file.write(f'    :hasCountry "{film_data["Country"]}" ;\n')
        rdf_file.write(f'    :hasGenres "{film_data["Genres"]}" ;\n')
        rdf_file.write(f'    :hasSinopsis "{film_data["Sinopsis"]}" ;\n')
        rdf_file.write(f'    :hasRating "{film_data["Rating"]}"^^xsd:decimal ;\n')
        rdf_file.write(f'    :hasDuration "{film_data["Duration"]}" ;\n')
        rdf_file.write(f'    :hasImage "{film_data["Image URL"]}" .\n\n')
        i+=1

def scrape_all_pages(driver, start_url, max_pages, rdf_output="patragay.ttl"):
    """
    Fungsi untuk scrape seluruh halaman dan menyimpan data dalam file RDF
    """
    driver.get(start_url)
    time.sleep(6)
    # current_page = 105  # halaman terakhir scraping 20 11 2024
    current_page = 76

    with open(rdf_output, 'w', encoding='utf-8') as rdf_file:
        # Menulis header RDF
        rdf_file.write("@prefix : <http://example.org/movie#> .\n")
        rdf_file.write("@prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .\n")
        rdf_file.write("@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .\n")
        rdf_file.write("@prefix xsd: <http://www.w3.org/2001/XMLSchema#> .\n\n")

        rdf_file.write(":Film rdf:type rdf:Class .\n")
        rdf_file.write(":hasTitle rdf:type rdf:Property ;\n")
        rdf_file.write("          rdfs:domain :Film ;\n")
        rdf_file.write("          rdfs:range xsd:string .\n\n")

        rdf_file.write(":hasDirector rdf:type rdf:Property ;\n")
        rdf_file.write("          rdfs:domain :Film ;\n")
        rdf_file.write("          rdfs:range xsd:string .\n\n")

        rdf_file.write(":hasReleaseDate rdf:type rdf:Property ;\n")
        rdf_file.write("                rdfs:domain :Film ;\n")
        rdf_file.write("                rdfs:range xsd:string .\n\n")

        rdf_file.write(":hasCountry rdf:type rdf:Property ;\n")
        rdf_file.write("                rdfs:domain :Film ;\n")
        rdf_file.write("                rdfs:range xsd:string .\n\n")

        rdf_file.write(":hasGenres rdf:type rdf:Property ;\n")
        rdf_file.write("           rdfs:domain :Film ;\n")
        rdf_file.write("           rdfs:range xsd:string .\n\n")

        rdf_file.write(":hasSinopsis rdf:type rdf:Property ;\n")
        rdf_file.write("             rdfs:domain :Film ;\n")
        rdf_file.write("             rdfs:range xsd:string .\n\n")

        rdf_file.write(":hasRating rdf:type rdf:Property ;\n")
        rdf_file.write("             rdfs:domain :Film ;\n")
        rdf_file.write("             rdfs:range xsd:decimal .\n\n")

        rdf_file.write(":hasDuration rdf:type rdf:Property ;\n")
        rdf_file.write("             rdfs:domain :Film ;\n")
        rdf_file.write("             rdfs:range xsd:string .\n\n")

        rdf_file.write(":hasImage rdf:type rdf:Property ;\n")
        rdf_file.write("          rdfs:domain :Film ;\n")
        rdf_file.write("          rdfs:range xsd:string .\n\n")

        # Scraping semua halaman
        while current_page <= max_pages:
            print(f"Scraping page {current_page}")

            # Scrape data di halaman saat ini
            scrape_page(driver, rdf_file)
            time.sleep(6)
            try:
                # pindah ke halaman berikutnya
                current_page += 1
                base_url = f"https://tv2.idlix.asia/movie/page/{current_page}/"
                driver.get(base_url)
                time.sleep(10)
            except Exception as e:
                print(f"Error while navigating to the next page: {e}")
                break  # Hentikan jika tidak bisa klik "Next"


# Main program
if __name__ == "__main__":
    # Setup driver
    driver = webdriver.Chrome()

    try:
        start_url = "https://tv2.idlix.asia/movie/page/76"
        scrape_all_pages(driver, start_url, max_pages=100)
    finally:
        driver.quit()
