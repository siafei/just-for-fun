import re

import os

def getlist():

    filename = raw_input('filename')

    print filename

    ft = open("url.txt",'w+')

    with open(str(filename), 'r') as f:

        lines = [line.strip() for line in f.readlines()]

        di = {}
        for x in lines:

            result = re.findall(r"\b(?:[0-9]{1,3}\.){3}[0-9]{1,3}\b", x)

            for y in result:
                if di.has_key(y) == False :
                        di[y] = 1
                        ft.write(y+'\n')


getlist()

print 'done'
