import shutil
import os, stat
os.chmod("/home/IdL/2021/tangyuhe/public_html/projet",stat.S_IRWXU|stat.S_IRWXG|stat.S_IRWXO)

shutil.rmtree("/home/IdL/2021/tangyuhe/public_html/projet/fichier_html")
shutil.rmtree("/home/IdL/2021/tangyuhe/public_html/projet/text_files")



