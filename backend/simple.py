from gettext import find
import requests
from lxml import etree
import re
from selenium import webdriver
import sys
import io
sys.stdout = io.TextIOWrapper(buffer=sys.stdout.buffer,encoding='utf8')
url = "http://w3.erss.univ-tlse2.fr/membre/tanguy/offres.html#Stages"
url_lin = "https://www.linkedin.com/jobs/search/?f_E=1&geoId=105015875&keywords=nlp&location=France"
days = 10


# <div class="job-flavors__label t-12 t-black--light t-normal">

# /html/body/a[4]/table/tbody/tr[3]/td[4]/a '+ str(i) +'
# /html/body/div[7]/div[3]/div[3]/div[2]/div/section[1]/div/div/ul
# /html/body/div[7]/div[3]/div[3]/div[2]/div/section[2]/div/div/div[1]/div/div[1]/div/div[2]/a/h2

def get_posts_linkedin(url_lin):
    posts = requests.get(url_lin)
    posts.encoding = "utf-8"

    selector = etree.HTML(posts.text)
    titles = selector.xpath('//*[@class="base-search-card__title"]/text()')
    locations = selector.xpath('//*[@class="job-search-card__location"]/text()')
    companies = selector.xpath('//*[@class="hidden-nested-link"]/text()')

    regex = '<a class="base-card__full-link" href="(.*)"'
    all_urls = re.findall(regex, posts.text)
    regex = 'datetime="(.*)">'
    dates = re.findall(regex, posts.text)
    
    for i in range(3):
        all_urls[i] = all_urls[i][:-66]
        filename = "text_files/linkedin" + str(i) + ".txt"

        title = titles[i].strip(" \n")
        location = locations[i].strip(" \n")
        company = companies[i].strip(" \n")
        list_date = dates[i].split("-")
        date = list_date[2] + "/" + list_date[1] + "/" + list_date[0]
        

        print(titles[i])
        with open(filename,'w',encoding="utf-8") as fd:
            fd.write("Titre: " + title + "\n")
            fd.write("Date: " + date + "\n")
            fd.write("Organisme: " + company + "\n")
            fd.write("Lieu: " + location + "\n\n\n")
            fd.write(all_urls[i] + "\n")

def get_posts(url):
    posts = requests.get(url)
    posts.encoding = "utf-8"

    regex = 'href="(.*)"'
    all_urls = re.findall(regex, posts.text)
    real_urls = []
    for u in all_urls:
        if "offres/S" in u:
            real_urls.append(u)

    real_urls = real_urls[:days]
    return real_urls

def get_content(real_urls, url):
    half_url = "http://w3.erss.univ-tlse2.fr/membre/tanguy/"
    if(real_urls == []):
        print("no urls\n")
    else:
        posts = requests.get(url)
        posts.encoding = "utf-8"
        selector = etree.HTML(posts.text)

        dates = []
        institutes = []
        places = []
        titles = []
        for i in range(2,days+2):
            date = selector.xpath("//tr[" + str(i) + "]/td[1]/text()")[2] # dates
            institute = selector.xpath("//tr[" + str(i) + "]/td[2]/text()")[2] # labos or firms
            place = selector.xpath("//tr[" + str(i) + "]/td[3]/text()")[2] # places
            title = selector.xpath("//tr[" + str(i) + "]/td[4]/a/text()")[2] # titles?

            dates.append(date)
            institutes.append(institute)
            places.append(place)
            titles.append(title)
     
        for i in range(len(real_urls)):

            c_post = requests.get(half_url + real_urls[i])
            c_post.encoding = "Windows-1252"
            filename = "text_files/stage" + str(i) + ".txt"
            with open(filename, "w", encoding = "utf-8") as fd:
                fd.write("Titre: " + titles[i] + "\n")
                fd.write("Date: " + dates[i] + "\n")
                fd.write("Organisme: " + institutes[i] + "\n")
                fd.write("Lieu: " + places[i] + "\n")
                fd.write(c_post.text)



# real_urls = get_posts(url)
# get_content(real_urls, url)

get_posts_linkedin(url_lin)   
