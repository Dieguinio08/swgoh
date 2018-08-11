# coding=utf-8
import urllib2,cookielib,sys,string

#Consigo la página del gremio
def descargoPag(site):
    hdr = {'User-Agent': 'Mozilla/5.0 (X11 Linux x86_64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11',
       'Accept': 'text/html,application/xhtml+xml,application/xmlq=0.9,*/*q=0.8',
       'Accept-Charset': 'ISO-8859-1,utf-8q=0.7,*q=0.3',
       'Accept-Encoding': 'none',
       'Accept-Language': 'en-US,enq=0.8',
       'Connection': 'keep-alive'}
    req = urllib2.Request(site, headers=hdr)
    try:
        page = urllib2.urlopen(req)
    except urllib2.HTTPError, e:
        print e.fp.read()
    return page.read()
gremio=descargoPag("https://swgoh.gg/g/9977/caballeros-de-la-republica/")

def classtitles(etiqueta):
    pos = gremio.find(etiqueta)
    pos = gremio.find ('value">',pos-50)
    pos2 = gremio.find('<',pos)
    return gremio[pos+7:pos2]

if (len(gremio)<200): 
    sys.exit()

#URl
pos = gremio.find("og:url") +17
pos2 = gremio.find('/>',pos)-2
url = gremio[pos: pos2]
print '{"GremioUrl":"'+url+'", '

#Numero Miembros
pos2 = gremio.find("Members")
pos = gremio.find( '>',pos2-10)+1
nroM = gremio[pos: pos2]
Nombre="caballeros-de-la-republica" #Arreglar
Numero=9977 #Arreglar
print '"NroMiembros":"'+nroM+'", "Nombre":"'+Nombre+'", "Numero":"'+Numero+'", '

#Los otros
raid=classtitles("Raid Points")
gp=classtitles("Galactic Power")
gp=string.replace(gp, ",","")
gr=classtitles("Guild Rank")
arena=classtitles("Arena Rank")
print '"RaidsL":"'+raid+'", '
print '"Poder":"'+gp+'", '
print '"Rango":"'+gr+'", '
print '"Arena":"'+arena+'", '

#Miembros
#en principio solo url completa y nombre
print '"Miembros":['
murl=[]
mnombre=[]
pos1=gremio.find("<tbody>")
for i in range(int(nroM)-1):
    pos1=gremio.find("value=",pos1)+7
    pos2=gremio.find (">",pos1)-1
    mnombre.append(i)
    mnombre[i]=gremio[pos1:pos2]
    pos1=pos2
    pos1=gremio.find("href=",pos1)+6
    pos2=gremio.find(">",pos1)-1
    murl.append(i)
    murl[i]="https://swgoh.gg"+gremio[pos1:pos2]
    pos1=pos2
marena=[] 
mgpc=[]
mgps=[]
mcscore=[]
mnroc=[]
aliado=[]
usuario=[]
cnombre=[]
cgear=[]
cstar=[]
cnivel=[]
cpower=[]
ctotal=[]
curl=[]
#for i in range(int(nroM)-1):
for i in range(2):
    miembro=descargoPag(murl[i])
    
    #usuario
    if(i>0):
        print ", "
    print '{"ID":"'+i+'", "Nombre":"'+mnombre[i]+'", "URL":"'+murl[i]+'", '
    usuario[i]=0 #Arreglar
    
    #aliado
    pos1=miembro.find("<p>Ally Code")
    if len(pos1)>0:
        pos2=miembro.find("</strong>",pos1)
        pos1=pos1+40
        aliado[i]=miembro[pos1:pos2]
    else: 
        aliado[i]=0
    print '"Ally":"'+aliado[i]+'", '

    #arena
    pos1=miembro.find("Arena Rank")
    pos2=miembro.find("</h5>",pos1)
    pos1=miembro.find( ">",pos2-6)+1
    marena[i]=miembro [pos1:pos2]
    print '"Arena":"'+marena[i]+'", '
    
    #Galactic Power C
    pos1=miembro.find("Galactic Power (Characters)")+55
    pos2=miembro.find("</strong></p>", pos1)
    mgpc[i]=miembro[pos1:pos2]
    mgpc[i]=string.replace(mgpc[i], ",","")
    pos1=pos2
    print '"PoderC":"'+mgpc[i]+'", '

    #Galactic Power S
    pos1=miembro.find("Galactic Power (Ships)")+50
    pos2=miembro.find("</strong></p>", pos1)
    mgps[i]=miembro [pos1:pos2]
    mgps[i]=string.replace(mgps[i], ",","")
    pos1=pos2
    print '"PoderS":"'+mgps[i]+'", '
    
    #Collection Score
    pos1=miembro.find("Collection Score")+42
    pos2=miembro.find("</h5>", pos1)
    mcscore[i]=miembro[pos1:pos2]
    pos1=pos2
    print '"Score":"'+mcscore[i]+'", '
    
    #Numero Colección
    pos1=miembro.find( "<h5 class=",pos1)
    pos2=miembro.find( "</h5>", pos1)
    pos1=miembro.find( ">", (pos2-10))+1
    mnroc[i]=miembro[pos1:pos2]
    pos1=pos2
    print '"NroPersonajes":"'+mnroc[i]+'", ';

    #Personajes
    coleccion=descargoPag(murl[i]+"collection/")
    pos1=0
    print '"Personajes":['
    #for j in range(int(mnroc[i])-1):
    for j in range(2):
        if(j>0):
            print ", "
        #url
        pos1=coleccion.find("player-char-portrait char-portrait-full", pos1)
        pos1=coleccion.find("href=", pos1)+6
        pos2=coleccion.find("class", pos1)-2
        curl[i][j]="https://swgoh.gg".coleccion[pos1: pos2]
        pos1=pos2
        print '{"Url":"'+curl[i][j]+'", '

        #Nombre
        pos1=coleccion.find("alt=", pos1)+5
        pos2=coleccion.find("height=", pos1)-3
        cnombre[i][j]=coleccion[pos1:pos2]
        cnombre[i][j]=string.replace(cnombre[i][j], '"','')
        pos1=coleccion.find(">", pos2)
        print '"Nombre":"'+cnombre[i][j]+'", '
        
        #estrellas
        pos2=coleccion.find("star-inactive", pos1)
        if len(pos2)>0 and (pos2-pos1)<270:
            cstar[i][j]=substr(coleccion, pos1, pos2)
        else:
            cstar[i][j]=7
        pos1=pos2
        print '"Estrellas":"'+cstar[i][j]+'", ';
        
        #Nivel
        pos1=coleccion.find("char-portrait-full-level", pos1)+26
        pos2=coleccion.find("</div>", pos1)
        cnivel[i][j]=coleccion[pos1: pos2]
        pos1=pos2
        print '"Nivel":"'+cnivel[i][j]+'", '
        
        #gear
        pos1=coleccion.find("char-portrait-full-gear-level", pos1)+31
        pos2=coleccion.find("</div>", pos1)
        cgear[i][j]=coleccion[pos1: pos2]
        pos1=pos2
        print '"Gear":"'+cgear[i][j]+'", '

        #Poder
        pos1=coleccion.find("Power", pos1)+6
        pos2=coleccion.find("/", pos1)-1
        cpower[i][j]=coleccion[pos1: pos2]
        cpower[i][j]=str_replace(",","",cpower[i][j])
        pos1=pos2
        print '"Poder":"'+cpower[i][j]+'", '
        
        #Total
        pos1=coleccion.find("collection-char-gp-progress-bar", pos1)+47
        pos2=coleccion.find("%", pos1)
        ctotal[i][j]=coleccion[pos1: pos2]
        pos1=pos2
        print '"Avance":"'+ctotal[i][j]+'"}'
    sleep(0.5)
    print ']}'
print ']}'