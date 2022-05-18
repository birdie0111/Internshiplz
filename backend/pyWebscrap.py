from bs4 import BeautifulSoup
from lxml import etree
import requests
import datetime
import os, stat
import chardet
import sys
import re
import io


#------------------------------------------------------------------------------------------définir les dossiers
# /home/IdL/2021/liuqinyu/public_html/fichier_html
# /home/IdL/2021/liuqinyu/public_html/text_files
# /home/IdL/2021/tangyuhe/public_html/fichier_html
# /home/IdL/2021/tangyuhe/public_html/text_files
roadPare = "/home/IdL/2021/tangyuhe/public_html" # obtenir le chemin du dossier
pathFile = roadPare+"/text_files"                       # définir le chemin des dossier .txt
if not os.path.exists(pathFile):                        # Si le dossier n'existe pas encore, créer un
     os.makedirs(pathFile, 0o777)
pathWindow = roadPare+"/fichier_html"                   # définir le chemin des dossier .html
if not os.path.exists(pathWindow):
    os.makedirs(pathWindow, 0o777)
# le mode est maintenant 755, il faut le changer en vrai 777 :
os.chmod(pathFile,stat.S_IRWXU|stat.S_IRWXG|stat.S_IRWXO)
os.chmod(pathWindow,stat.S_IRWXU|stat.S_IRWXG|stat.S_IRWXO)



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
        filename = pathFile+"/Linkedin" + str(i) + ".txt"
        fileWindow = pathWindow+"/Linkedin" + str(i) + ".html"

        title = titles[i].strip(" \n")
        location = locations[i].strip(" \n")
        company = companies[i].strip(" \n")
        list_date = dates[i].split("-")
        #date = list_date[2] + "/" + list_date[1] + "/" + list_date[0]
        date = list_date[0] + "-" + list_date[1] + "-" + list_date[2]
        

        # print(titles[i])
        with open(filename,'w',encoding="UTF-8") as fd:
            os.chmod(filename,stat.S_IRWXU|stat.S_IRWXG|stat.S_IRWXO)
            fd.write("Titre: " + title + "\n")
            fd.write("Date: " + date + "\n")
            fd.write("Organisme: " + company + "\n")
            fd.write("Lieu: " + location + "\n\n\n")
            fd.write(all_urls[i] + "\n")
        with open(fileWindow,'w',encoding="Windows-1252") as fd:
            os.chmod(fileWindow,stat.S_IRWXU|stat.S_IRWXG|stat.S_IRWXO)
            fd.write("""<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="Windows-1252">
    <title> Internshiplz - Yuhe TANG - Qinyue LIU - M1 IDL </title>
    <link rel="stylesheet" type="text/css" media="all" href="../FichierHtml_style.css" />
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
            dateOrigin = selector.xpath("//tr[" + str(i) + "]/td[1]/text()")[2] # dates
            list_date = dateOrigin.split("/")
            date = list_date[2] + "-" + list_date[1] + "-" + list_date[0]
            institute = selector.xpath("//tr[" + str(i) + "]/td[2]/text()")[2] # labos or firms
            place = selector.xpath("//tr[" + str(i) + "]/td[3]/text()")[2] # places
            title = selector.xpath("//tr[" + str(i) + "]/td[4]/a/text()")[2] # titles?

            dates.append(date)
            institutes.append(institute)
            places.append(place)
            titles.append(title)
     
        for i in range(len(real_urls)):

            c_post = requests.get(half_url + real_urls[i])
            encod = chardet.detect(c_post.content)['encoding'] # important, obtenir la valeur de encoding de detection
            if encod == "utf-8":
                c_post.encoding = encod
            else : 
                c_post.encoding = "windows-1252"
            c_corri = c_post.text
            # (?<!(>|\n|\.|[A-Z]|[0-9]))\n(?!(<|\s|•|[1-9]\.|— |– |- |[A-Z]))
            regex = r"(?<!(>|\n|\.|[A-Z]|[0-9]))\n(?!(<|\s|•|[1-9]\.|— |– |- |[A-Z]))"
            c_corri_final = re.sub(regex," ",c_corri)

            filename = pathFile+"/Stage" + str(i) + ".txt"
            fileWindow = pathWindow+"/Stage" + str(i) + ".html"


            with open(filename, "w", encoding = "UTF-8") as fd:
                os.chmod(filename,stat.S_IRWXU|stat.S_IRWXG|stat.S_IRWXO)
                fd.write("Titre: " + titles[i] + "\n")
                fd.write("Date: " + dates[i] + "\n")
                fd.write("Organisme: " + institutes[i] + "\n")
                fd.write("Lieu: " + places[i] + "\n\n\n")
                fd.write(c_corri_final)
            with open(fileWindow, "w", encoding = "UTF-8") as fd:
                os.chmod(fileWindow,stat.S_IRWXU|stat.S_IRWXG|stat.S_IRWXO)
                fd.write("""<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title> Internshiplz - Yuhe TANG - Qinyue LIU - M1 IDL </title>
    <link rel="stylesheet" type="text/css" media="all" href="../FichierHtml_style.css" />
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
# a = divA.find_all('a', rel="nofollow",target="_blank")
a = divA.find_all('a', class_="jcs-JobTitle" , target="_blank")
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
            Date = Date.strftime("%Y-%m-%d")
            return Date
        if "instant" in chaine or "Aujourd'hui" in chaine :
            Date = datetime.date.today()
            Date = Date.strftime("%Y-%m-%d")
            return Date

def getContent(urlStage):
    htmlStage = getUrl(urlStage)
    head = htmlStage.xpath('//*[@id="viewJobSSRRoot"]/div[1]/div/div[3]/div/div/div[1]/div[1]/div[2]//text()')
    body = htmlStage.xpath('//*[@id="jobDescriptionText"]//text()')
    content = head + body
    return content # obtenir une liste des chaînes

# pour chaque site du stage, obtenir les informations et les écrire dans un fichier .txt

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
    txt = open(filename, "w+", encoding = "UTF-8")
    os.chmod(filename,stat.S_IRWXU|stat.S_IRWXG|stat.S_IRWXO)
    txt.write("Titre: " + title + "\n")
    txt.write("Date: " + date + "\n")
    txt.write("Organisme: " + inst + "\n")
    txt.write("Lieu: " + place + "\n")
    txt.write("\n\n")
    for line in content : # écrire ligne par ligne
        txt.write(line)
    txt.close()
    
    fileWindow = pathWindow+"/Indeed" + str(i) + ".html"
    html = open(fileWindow, "w+", encoding = "UTF-8")
    os.chmod(fileWindow,stat.S_IRWXU|stat.S_IRWXG|stat.S_IRWXO)
    html.write("""<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title> Internshiplz - Yuhe TANG - Qinyue LIU - M1 IDL </title>
    <link rel="stylesheet" type="text/css" media="all" href="../FichierHtml_style.css" />
</head>

<body>""")
    html.write("<p>Titre: " + title + "</p>")
    html.write("<p>Date: " + date + "</p>")
    html.write("<p>Organisme: " + inst + "</p>")
    html.write("<p>Lieu: " + place + "</p><br/>")
    for line in content : # écrire ligne par ligne
        html.write("<p>" + line + "</p>")
    html.write("""
</body>
</html>
        """)
    html.close()


print("Script fini, ça marche ! Vérifiez les résultats dans \"...\Internshiplz\\text_files\" et dans \"...\Internshiplz\\fichier_html\" ")