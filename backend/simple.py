from gettext import find
import requests
from lxml import etree
import re
url = "http://w3.erss.univ-tlse2.fr/membre/tanguy/offres.html#Stages"
days = 10


# /html/body/a[4]/table/tbody/tr[2]/td[4]/a
# /html/body/a[4]/table/tbody/tr[3]/td[4]/a /html/body/a[4]/table/tbody/tr[1]/td/div/span
# /html/body/a[4]/table/tbody/tr[3]/td[4]/a '+ str(i) +'
def get_posts(url):
    posts = requests.get(url)
    posts.encoding = "utf-8"

    regex = 'href="(.*)"'
    all_urls = re.findall(regex,posts.text)
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
        for i in range(2,days+2):
            date = selector.xpath("//tr[" + str(i) + "]/td[1]/text()")[2] # dates
            institute = selector.xpath("//tr[" + str(i) + "]/td[2]/text()")[2] # labos or firms
            place = selector.xpath("//tr[" + str(i) + "]/td[3]/text()")[2] # dates

            dates.append(date)
            institutes.append(institute)
            places.append(place)
        
        for i in range(len(real_urls)):

            c_post = requests.get(half_url + real_urls[i])
            c_post.encoding = "Windows-1252"

            filename = "stage" + str(i) + ".txt"
            with open(filename, "w", encoding = "utf-8") as fd:
                fd.write("date: " + dates[i] + "\n")
                fd.write("institute: " + institutes[i] + "\n")
                fd.write("places: " + places[i] + "\n")
                fd.write(c_post.text)

    

real_urls = get_posts(url)
get_content(real_urls, url)
    