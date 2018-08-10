# coding=utf-8
import urllib2
import sys

#Consigo la página del gremio
conexion = urllib2.urlopen('https://swgoh.gg/g/9977/caballeros-de-la-republica/')
gremio=conexion.read()

#creo la funcion
def classtitles(etiqueta):
    pos = gremio.find(etiqueta)
    pos = gremio.find ('value">',pos-50)
    pos2 = gremio.find('<',pos)
    return gremio[pos+7, (pos2-pos)]

if (len(gremio)<200): 
    sys.exit()

#URl
pos = gremio.find("og:url") 
pos2 = gremio.find('/>',pos)
pos3=(pos2-pos)-19
url = gremio[pos+17, pos3]

#Numero Miembros
print url