#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Thu Apr  8 15:40:34 2021

@author: thierry
"""

import requests
from bs4 import BeautifulSoup
from xml import etree
from xml.etree import ElementTree


base = 'http://www.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=Pubmed&retmax=1&usehistory=y&term='
pmid = str(31198441)
search = requests.get(base + pmid)
tree = ElementTree.fromstring(search.content)
Web_env = tree.find("WebEnv").text
print(web_env)
base1 = "http://www.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?rettype=abstract&retmode=xml&db=Pubmed&query_key=1&WebEnv=" + web_env
url = base1 + "&usehistory=y&term=" + pmid;
output = requests.get(url)
tree2 = etree.parse(output.content)
year = tree2.find("PubDate")




