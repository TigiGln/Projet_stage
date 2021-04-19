#!/usr/bin/env python3
import requests
import re
from bs4 import BeautifulSoup
from lxml import etree

def cut(out, element:str):
    out = out.split("<" + element + ">")
    out = out[1].split("</" + element + ">")
    return str(out[0])
 
def cut_abst(out, element1:str, element2:str):
    out = out.split("<" + element1 + ">")
    out = out[1].split("</" + element2 + ">")
    return str(out[0])
#
#def recup_info(out, elemt:str):
#    elemt = elemt.lower()
#    var = out.find(elemt)
#    return var

#def recup_article():
base = 'http://www.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=Pubmed&retmax=1&usehistory=y&term='
pmid = str(31198441)
search = requests.get(base + pmid)
sch = str(search.text)
sc = BeautifulSoup(sch)
web_env = sc.find("webenv").string
  #print (web_env)
base1 = "http://www.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?rettype=abstract&retmode=xml&db=Pubmed&query_key=1&WebEnv=" + web_env
url = base1 + "&usehistory=y&term=" + pmid;
output = requests.get(url)
print(type(output.content))
output = BeautifulSoup(output)

years = output.find("pubdate/year")


    

#  years = cut(output, "PubDate")
#  years = cut(years, "Year")
#
#  title = cut(output, "ArticleTitle")
#
#  listabstract = cut(output, "Abstract")
#  listabstract = listabstract.split("\n")
#  #print(listabstract)
#  abstract = ""
#  for elem in listabstract:
#      elem = elem.strip()
#      elem = cut_abst(elem, 'AbstractText Label="Background" NlmCategory="UNASSIGNED"', "AbstractText")
#      abstract += elem
#      print(elem)
#  print(abstract)    
#  return (years, title, abstract)
#
#years, title, abstract = recup_article()
#print("Annee: ", years, "\n", "Titre: ", title, "\n", "Resume: ", abstract)



