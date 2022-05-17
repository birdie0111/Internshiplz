

from bs4 import BeautifulSoup
from lxml import etree
import requests
import datetime
import sys
import re
import io
import os

#------------------------------------------------------------------------------------------Internshiplz---Qinyue-LIU---M1-IDL---24/03/2022
#------------------------------------------------------------------------------------------"Offres d'emploi et de stage en TAL"---et---"Linkedin"

sys.stdout = io.TextIOWrapper(buffer=sys.stdout.buffer,encoding='utf8')
url = "http://w3.erss.univ-tlse2.fr/membre/tanguy/offres.html#Stages"
url_lin = "https://www.linkedin.com/jobs/search?keywords=Nlp&location=France&locationId=&geoId=105015875&f_TPR=&f_JT=I"
days = 20

def get_posts_linkedin(url_lin):
    posts = requests.get(url_lin)
    posts.encoding = "utf-8"

    selector = etree.HTML(posts.text)
    titles = selector.xpath('//*[@class="base-search-card__title"]/text()')
    locations = selector.xpath('//*[@class="job-search-card__location"]/text()')
    companies = selector.xpath('//*[@class="hidden-nested-link"]/text()')

    regex = 'href="(.*)" data-tracking-control-name="public_jobs_jserp-result_search-card"'
    all_urls = re.findall(regex, posts.text)
    regex = 'datetime="(.*)">'
    dates = re.findall(regex, posts.text)
    
    for i in range(3):
        #sftp://liuqinyu@i3l.univ-grenoble-alpes.fr/home/IdL/2021/liuqinyu/public_html/new/fichier_html
        roadPare = "/home/IdL/2021/liuqinyu/public_html" # obtenir le chemin du dossier
        pathFile = roadPare+"/text_files" # définir le chemin des dossier
        filename = pathFile+"/Linkedin" + str(i) + ".txt"
        pathWindow = roadPare+"/fichier_html" # le dossier pour les .txt en Encodage Windows1252
        fileWindow = pathWindow+"/Linkedin" + str(i) + ".html"



        title = titles[i].strip(" \n")
        location = locations[i].strip(" \n")
        company = companies[i].strip(" \n")
        list_date = dates[i].split("-")
        date = list_date[2] + "/" + list_date[1] + "/" + list_date[0]
        

        # print(titles[i])
        with open(filename,'w',encoding="UTF-8") as fd:
            fd.write("Titre: " + title + "\n")
            fd.write("Date: " + date + "\n")
            fd.write("Organisme: " + company + "\n")
            fd.write("Lieu: " + location + "\n\n\n")
            fd.write(all_urls[i] + "\n")
        with open(fileWindow,'w',encoding="Windows-1252") as fd:
            fd.write("""<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="Windows-1252">
    <title> Internshiplz - Yuhe TANG - Qinyue LIU - M1 IDL </title>
    <style type="text/css">
    </style>
</head>

<body>""")
            fd.write("<p>Titre: " + title + "</p>")
            fd.write("<p>Date: " + date + "</p>")
            fd.write("<p>Organisme: " + company + "</p>")
            fd.write("<p>Lieu: " + location + "</p><br/>")
            fd.write("<p>"+all_urls[i] + "</p>")
            fd.write("""
</body>
</html>
        """)

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
            c_corri = c_post.text
            # (?<!(>|\n|\.|[A-Z]|[0-9]))\n(?!(<|\s|•|[1-9]\.|— |– |- |[A-Z]))
            regex = r"(?<!(>|\n|\.|[A-Z]|[0-9]))\n(?!(<|\s|•|[1-9]\.|— |– |- |[A-Z]))"
            c_corri_final = re.sub(regex," ",c_corri)

            roadPare = "/home/IdL/2021/liuqinyu/public_html"
            pathFile = roadPare+"/text_files"
            filename = pathFile+"/Stage" + str(i) + ".txt"
            pathWindow = roadPare+"/fichier_html" # le dossier pour les .txt en Encodage Windows1252
            fileWindow = pathWindow+"/Stage" + str(i) + ".html"


            with open(filename, "w", encoding = "UTF-8") as fd:
                fd.write("Titre: " + titles[i] + "\n")
                fd.write("Date: " + dates[i] + "\n")
                fd.write("Organisme: " + institutes[i] + "\n")
                fd.write("Lieu: " + places[i] + "\n\n\n")
                fd.write(c_corri_final)
            with open(fileWindow, "w", encoding = "Windows-1252") as fd:
                fd.write("""<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="Windows-1252">
    <title> Internshiplz - Yuhe TANG - Qinyue LIU - M1 IDL </title>
    <style type="text/css">
    </style>
</head>

<body>""")
                fd.write("<p>Titre: " + titles[i] + "</p>")
                fd.write("<p>Date: " + dates[i] + "</p>")
                fd.write("<p>Organisme: " + institutes[i] + "</p>")
                fd.write("<p>Lieu: " + places[i] + "</p><br/>")
                fd.write("<p>")
                for cara in c_corri_final: 
                    if cara != "\n":
                        fd.write(cara)
                    else :
                        fd.write("</p><p>")
                fd.write("</p>")
                fd.write("""
</body>
</html>
        """)

get_posts_linkedin(url_lin)

real_urls = get_posts(url)
get_content(real_urls, url)




#---------------------------------------------------------------------------------------------------Internshiplz---Yuhe-TANG---M1-IDL---29/03/2022
#---------------------------------------------------------------------------------------------------"Indeed"
urlIndeed = "https://fr.indeed.com/emplois?q=traitement+automatique+des+langues&jt=internship"

# obtenir les codes html de la page Indeed
server = "https://fr.indeed.com"
target = urlIndeed
req = requests.get(url = target)
html = req.text

# obtenir les urls des pages de stages
urls = []
divJobcard = BeautifulSoup(html,'lxml')
jobcard = divJobcard.find('div', id = 'mosaic-provider-jobcards')
divA = BeautifulSoup(str(jobcard),'lxml')
a = divA.find_all('a', rel="nofollow",target="_blank")
for hrefStage in a :
    href = server + hrefStage.get('href')
    urls.append(href)

# obtenir html du site Indeed
def getUrl(urlhtml):
    response = requests.get(url=urlhtml)
    wb_data = response.text
    html = etree.HTML(wb_data) 
    return html

# obtenir les titres des stages
def getTitle(urlStage) : 
    htmlStage = getUrl(urlStage)
    title = htmlStage.xpath('//*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[2]/div[1]/div[1]/h1/text()')
    #                        //*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[3]/div[1]/div[1]/h1
    #                        //*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[2]/div[1]/div[1]/h1
    if len(title) == 0 : 
        title = htmlStage.xpath('//*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[3]/div[1]/div[1]/h1/text()')
    return title[0] # avoir une liste avec un seul titre, pour obtenir le titre seulement, utiliser indice = 0

# obtenir les institues des stages
def getInst(urlStage):
    htmlStage = getUrl(urlStage)
    institue = htmlStage.xpath('//*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[2]/div[1]/div[2]/div/div/div/div[1]/div[2]/div//text()')
    if len(institue) == 0 : 
        institue = htmlStage.xpath('//*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[3]/div[1]/div[2]/div/div/div/div[1]/div[2]/div//text()')
    #                           //*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[3]/div[1]/div[2]/div/div/div/div[1]/div[2]/div/a
    return institue[0]

# obtenir les lieux des stages
def getPlace(urlStage):
    htmlStage = getUrl(urlStage)
    place = htmlStage.xpath('//*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[2]/div[1]/div[2]/div/div/div/div[2]/div/text()')
    if len(place) == 0 :
        place = htmlStage.xpath('//*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[3]/div[1]/div[2]/div/div/div/div[2]/div/text()')
    return place[0]

# obtenir les dates des stages
def getDate(urlStage):
    htmlStage = getUrl(urlStage)
    dateChaine = htmlStage.xpath('//*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[6]/div[2]//text()')
    if len(dateChaine) == 0 :
        dateChaine = htmlStage.xpath('//*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[7]/div[2]//text()')
    for chaine in dateChaine :
        if "il y a" in chaine :
            entre = str(chaine)
            numDate = int(entre[7:9])
            today = datetime.date.today()
            Date = today - datetime.timedelta(days=numDate)
            Date = Date.strftime("%d/%m/%Y")
            return Date
        if "instant" in chaine or "Aujourd'hui" in chaine :
            Date = datetime.date.today()
            Date = Date.strftime("%d/%m/%Y")
            return Date

def getContent(urlStage):
    htmlStage = getUrl(urlStage)
    head = htmlStage.xpath('//*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[2]//text()')
    body = htmlStage.xpath('//*[@id="jobDescriptionText"]//text()')
    content = head + body
    return content # obtenir une liste des chaînes

# pour chaque site du stage, obtenir les informations et les écrire dans un fichier .txt

roadPare = "/home/IdL/2021/liuqinyu/public_html"
pathFile = roadPare+"/text_files"

pathWindow = roadPare+"/fichier_html" # le dossier pour les .txt en Encodage Windows1252

for href in urls : 
    # obtenir les informations
    # pour test : print(str(href))
    title = getTitle(href)
    date = getDate(href)
    inst = getInst(href)
    place = getPlace(href)
    content = getContent(href) # une liste mais pas str
    # et les écrire dans un fichier .txt
    i = urls.index(href)

    filename = pathFile+"/Indeed" + str(i) + ".txt"
    txt = open(filename, "w", encoding = "UTF-8")
    txt.write("Titre: " + title + "\n")
    txt.write("Date: " + date + "\n")
    txt.write("Organisme: " + inst + "\n")
    txt.write("Lieu: " + place + "\n")
    txt.write("\n\n")
    for line in content : # écrire ligne par ligne
        txt.write(line)
    
    fileWindow = pathWindow+"/Indeed" + str(i) + ".html"
    txt = open(fileWindow, "w", encoding = "utf-8")
    txt.write("""<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title> Internshiplz - Yuhe TANG - Qinyue LIU - M1 IDL </title>
    <style type="text/css">
    </style>
</head>

<body>""")
    txt.write("<p>Titre: " + title + "</p>")
    txt.write("<p>Date: " + date + "</p>")
    txt.write("<p>Organisme: " + inst + "</p>")
    txt.write("<p>Lieu: " + place + "</p><br/>")
    for line in content : # écrire ligne par ligne
        txt.write("<p>" + line + "</p>")
    txt.write("""
</body>
</html>
        """)

#print("Script fini, ça marche ! Vérifiez les résultats dans \"...\Internshiplz\\text_files\" et dans \"...\Internshiplz\\fichier_html\" ")