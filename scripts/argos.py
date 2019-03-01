# -*- coding: utf-8 -*-

import urllib.request
import urllib.parse
import json

def extractSessionCookie(response):
    cookie = response.getheader('Set-Cookie')
    if cookie != None:
        #print("cookie", cookie)
        cookie = cookie.split(";")[0]
        #print("cookie", cookie)
        
        name = cookie.split("=")[0]
        if name == "IDHTTPSESSIONID":
            return cookie
    #print("No hay cookie IDHTTPSESSIONID")
    return None
    
def getSessionID():
    response = urllib.request.urlopen("https://argos.ucn.cl/mw/Server.Properties.Get")
    #body = response.read()    
    return extractSessionCookie(response)

def doAuth(cookie, username="155726997",password="contreras2018"):
    data = urllib.parse.urlencode({
                                    "username":username, 
                                    "password":password,
                                    "Application": "ArgosWeb"
                                  }).encode("utf-8")        
                                  
    request = urllib.request.Request("https://argos.ucn.cl/mw/Session.Authenticate", data, headers={ 'Cookie': cookie })
    response = urllib.request.urlopen(request)
    
    contentType = response.getheader('Content-Type')
    if contentType != "application/json":
        print("Content type is " + str(contentType))
        return None
    
    charset = response.info().get_content_charset()
    if charset == None:
        charset = "ASCII"

    body = response.read()
    body = body.decode(charset)
    
    jbody = json.loads(body)
    if not "valid" in jbody:
        print("Response no contiene VALID")
        return None
    if not jbody["valid"]:
        print("Auth no válida")
        return None
            
    newCookie = extractSessionCookie(response)
    if newCookie != None:
        return newCookie
    return cookie
        
def callReport(cookie, data):
#    data = urllib.parse.urlencode({
#                "Connection": "CONSULTA_BANNER",
#                "Product": "Argos",
#                "UniqueId": '{"DataBlock":{"Id":304,"SQLName":"mclAlumInscNrc"}}',
#                "JSONData": '{"Variables":[{"Value":"201710","Type":"WideString","Name":"ddlPeriodo.CODIGO_PERIODO"},{"Value":"12122","Type":"String","Name":"tbxNrc"}]}'
#           })#.encode("ASCII")
                                  
    data = data.encode("utf-8")
    request = urllib.request.Request("https://argos.ucn.cl/mw/Sql.QuickOpen", data, headers={ 'Cookie': cookie, 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' })
    response = urllib.request.urlopen(request)
    
    contentType = response.getheader('Content-Type')
    if contentType != "application/json":
        print("Content type is " + str(contentType))
        return None
    
    charset = response.info().get_content_charset()
    if charset == None:
        charset = "ASCII"

    body = response.read()
    body = body.decode(charset)
    
    jbody = json.loads(body)
    if not "valid" in jbody:
        print("callReport no contiene VALID")
        return None
    if not jbody["valid"]:
        print("callReport no válida")
        print(jbody)
        return None
            
    jdata = jbody["data"]
    fields = jdata["Fields"]
    fieldNames = [ x['Name'] for x in fields ]
    records = jdata["Records"]
    
    #print("Fields:" + str(fieldNames))

    def recordMapper(r):
        nonlocal fieldNames        
        h = { f:v for f,v in zip(fieldNames, r) }        
        return h
    
    result = list(map(recordMapper, records))
    #print(result)
    return result
    
def callReportAlumInscNrc(cookie, periodo, nrc):
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":304,"SQLName":"mclAlumInscNrc"}}',
                "JSONData": '{"Variables":[{"Value":"'+str(periodo)+'","Type":"WideString","Name":"ddlPeriodo.CODIGO_PERIODO"},{"Value":"'+str(nrc)+'","Type":"String","Name":"tbxNrc"}]}'
           })#.encode("ASCII")
    return callReport(cookie, data)
    
def callReportAlumMatriculadosPeriodo(cookie, periodo):
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":522,"SQLName":"mclAlumInscNrc"}}',
                "JSONData": '{"Variables":[{"Value":"'+str(periodo)+'","Type":"WideString","Name":"ddlPeriodo.CODIGO_PERIODO"}]}'
           })#.encode("ASCII")
    return callReport(cookie, data)
    
def callReportOfertaAcademica(cookie, periodo):
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":912,"SQLName":"mlcOfertaAcademica"}}',
                "JSONData": '{"Variables":[{"Value":"'+str(periodo)+'","Type":"WideString","Name":"ddlPeriodo.CODIGO_PERIODO"}]}'
           })#.encode("ASCII")
    return callReport(cookie, data)

def callReportEstudiantesPorNivel(cookie, periodo, codCarrera):
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":817,"SQLName":"mlcInfoAsig1"}}',
                "JSONData": '{"Variables":[{"Value":"' + str(periodo) + '","Type":"WideString","Name":"ddlPeriodo.CODPERIODO"},{"Value":"' + str(codCarrera) + '","Type":"WideString","Name":"dllCarrera.CODCARRERA"},{"Value":null,"Type":"WideString","Name":"dllEstado.CODIGO"}]}'
           })#.encode("ASCII")
    return callReport(cookie, data)

def callReportCalificacionesFinales(cookie, nrc, periodo):
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":493,"SQLName":"MultiColumn1"}}',
                "JSONData": '{"Variables":[{"Value":"' + str(periodo) + '","Type":"WideString","Name":"ddlPeriodo.CODIGO_PERIODO"},{"Value":"' + str(nrc) + '","Type":"String","Name":"tbxNRC"}]}'
           })#.encode("ASCII")
    return callReport(cookie, data)

def callReportEstudiantesEliminados(cookie, periodo):
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":1285,"SQLName":"mclHistAcad"}}',
                "JSONData": '{"Variables":[{"Value":"' + str(periodo) + '","Type":"WideString","Name":"PeriodoActual.CODPERIODO"}]}'
           })#.encode("ASCII")
    return callReport(cookie, data)

def callReportIngresoOportunoCalificaciones(cookie, periodo, materia, curso):
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":2137,"SQLName":"mlcInfoAsig"}}',
                "JSONData": '{"Variables":[{"Value":"' + str(periodo) + '","Type":"WideString","Name":"ddlPeriodo.CODIGO_PERIODO"},{"Value":null,"Type":"String","Name":"tbxAsignatura"},{"Value":"' + str(curso) + '","Type":"String","Name":"tbxCurso"},{"Value":"' + str(materia) + '","Type":"String","Name":"tbxMateria"},{"Value":null,"Type":"String","Name":"tbxNrc"}]}'
           })#.encode("ASCII")
    return callReport(cookie, data)

def callReportPeriodosVigentesPregrado(cookie):
    tipo = "PR"
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":2075,"SQLName":"ddlPeriodo"}}',
                "JSONData": '{"Variables":[{"Value":"' + str(tipo) + '","Type":"String","Name":"ddlNivel.Codigo"}]}'				
           })#.encode("ASCII")
    return callReport(cookie, data)

        
# Vigentes:"Value":   "0,9,A,C,D,F,H,I,J,  M,N,P,Q,S,T,  W,X,Y,Ñ"
#                      0,9,A,C,D,F,H,I,J,M,N,P,Q,S,T,W,X,Y,Ñ
#
# NoVigentes: "Value":   "B,  E,G,    K,L,  O,  R,  U,V,    Z",
#                         B,  E,G,    K,L,  O,  R,  U,V,    Z
#
def callReportEstudiantesVigentesCarrera(cookie, periodo, carrera):
    nivel = "PR" # PR:pregrado, PO:postgrado
    estado = "0,9,A,C,D,F,H,I,J,M,N,P,Q,S,T,W,X,Y,Ñ"
        
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":2075,"SQLName":"MultiColumn1"}}',
                                "JSONData": '{"Variables":[{"Value":"' + str(carrera) + '","Type":"WideString","Name":"ddlCarrera.CODCARRERA"},{"Value":"' + str(estado) + '","Type":"WideString","Name":"ddlEstado.CODESTADO"},{"Value":"' + str(nivel) + '","Type":"String","Name":"ddlNivel.Codigo"},{"Value":"' + str(periodo) + '","Type":"WideString","Name":"ddlPeriodo.CODPERIODO"}]}'
           })#.encode("ASCII")
    return callReport(cookie, data)

def callReportEstudiantesNoVigentesCarrera(cookie, periodo, carrera):
    nivel = "PR" # PR:pregrado, PO:postgrado
    estado = "B,E,G,K,L,O,R,U,V,Z"
        
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":2075,"SQLName":"MultiColumn1"}}',
                                "JSONData": '{"Variables":[{"Value":"' + str(carrera) + '","Type":"WideString","Name":"ddlCarrera.CODCARRERA"},{"Value":"' + str(estado) + '","Type":"WideString","Name":"ddlEstado.CODESTADO"},{"Value":"' + str(nivel) + '","Type":"String","Name":"ddlNivel.Codigo"},{"Value":"' + str(periodo) + '","Type":"WideString","Name":"ddlPeriodo.CODPERIODO"}]}'
           })#.encode("ASCII")
    return callReport(cookie, data)


# def callReportEstudiantesCarrera(cookie, periodo, carrera):
#     nivel = "PR" # PR:pregrado, PO:postgrado
# #     estado = "0,A,C,D,F,H,I,J,M,N,P,Q,S,T,W,X,Y,Ñ,B,E,G,K,L,O,R,U,V,Z"
#     estado = "0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,Ñ"
#     data = urllib.parse.urlencode({
#                 "Connection": "CONSULTA_BANNER",
#                 "Product": "Argos",
#                 "UniqueId": '{"DataBlock":{"Id":2075,"SQLName":"MultiColumn1"}}',
# 				"JSONData": '{"Variables":[{"Value":"' + str(carrera) + '","Type":"WideString","Name":"ddlCarrera.CODCARRERA"},{"Value":"' + str(estado) + '","Type":"WideString","Name":"ddlEstado.CODESTADO"},{"Value":"' + str(nivel) + '","Type":"String","Name":"ddlNivel.Codigo"},{"Value":"' + str(periodo) + '","Type":"WideString","Name":"ddlPeriodo.CODPERIODO"}]}'
#            })#.encode("ASCII")
#     return callReport(cookie, data)

def callReportEstudiantesCarreraEstado(cookie, periodo, carrera, estado):
    nivel = "PR" # PR:pregrado, PO:postgrado
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":2075,"SQLName":"MultiColumn1"}}',
                                "JSONData": '{"Variables":[{"Value":"' + str(carrera) + '","Type":"WideString","Name":"ddlCarrera.CODCARRERA"},{"Value":"' + str(estado) + '","Type":"WideString","Name":"ddlEstado.CODESTADO"},{"Value":"' + str(nivel) + '","Type":"String","Name":"ddlNivel.Codigo"},{"Value":"' + str(periodo) + '","Type":"WideString","Name":"ddlPeriodo.CODPERIODO"}]}'
           })#.encode("ASCII")
    return callReport(cookie, data)


def callReportMallaCarrera(cookie, periodo, codCarrera, catalogo):
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":2082,"SQLName":"Mallas"}}',
                "JSONData": '{"Variables":[{"Value":null,"Type":"WideString","Name":"ddlArea.SMRACAA_AREA"},{"Value":"' + str(codCarrera)+ '","Type":"WideString","Name":"ddlCarrera.CODCARRERA"},{"Value":"'+str(catalogo)+'","Type":"WideString","Name":"ddlCatalogo.CATALOGO"}]}'
           })#.encode("ASCII")
    return callReport(cookie, data)

# [{'CATALOGO': '201610'}, {'CATALOGO': '201010'}, {'CATALOGO': '000000'}]
def callReportCatalogosCarrera(cookie, periodo, codCarrera):
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":2082,"SQLName":"ddlCatalogo"}}',
                "JSONData": '{"Variables":[{"Value":"'+str(codCarrera)+'","Type":"WideString","Name":"ddlCarrera.CODCARRERA"}]}'
           })#.encode("ASCII")
    return callReport(cookie, data)

# {'CARRERA': 'Traductor Bilingüe', 'DESCCARRERA': '8133 - Traductor Bilingüe', 'NOMCARRERA': 'TRADUCTOR BILINGÜE', 'CODCARRERA': '8133'}
def callReportListaCarreras(cookie):
    nivel = "PR" # PR:pregrado, PO:postgrado
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":2082,"SQLName":"ddlCarrera"}}',
                "JSONData": '{"Variables":[{"Value":"' + nivel + '","Type":"String","Name":"ddlNivel.Codigo"}]}'
           })#.encode("ASCII")
    return callReport(cookie, data)

# [{'AREA': '8606-S01', 'SMRACAA_AREA': '8606-S01'}, {'AREA': '8606-S02', 'SMRACAA_AREA': '8606-S02'}, {'AREA': '8606-S03', 'SMRACAA_AREA': '8606-S03'}, {'AREA': '8606-S04', 'SMRACAA_AREA': '8606-S04'}, {'AREA': '8606-S06', 'SMRACAA_AREA': '8606-S06'}, {'AREA': '8606-S07', 'SMRACAA_AREA': '8606-S07'}, {'AREA': '8606-S08', 'SMRACAA_AREA': '8606-S08'}, {'AREA': '8606-S09', 'SMRACAA_AREA': '8606-S09'}, {'AREA': '8606-S10', 'SMRACAA_AREA': '8606-S10'}, {'AREA': '8606-SR5', 'SMRACAA_AREA': '8606-SR5'}]
def callReportAreasCatalogo(cookie, codCarrera, catalogo):
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":2082,"SQLName":"ddlArea"}}',
                "JSONData": '{"Variables":[{"Value":"'+codCarrera+'","Type":"WideString","Name":"ddlCarrera.CODCARRERA"},{"Value":"'+catalogo+'","Type":"WideString","Name":"ddlCatalogo.CATALOGO"}]}'
           })#.encode("ASCII")
    return callReport(cookie, data)


# {'FECHA_TITULO': '30-04-2003', 
# 'COD_CARRERA': '8373', 
# 'ANHIO_INGRESO': '1995', 
# 'SEGUNDO_NOMBRE': None, 
# 'DV': '3', 
# 'APELLIDO_PATERNO': 'CALLE', 
# 'NACIONALIDAD': 'CHL', 
# 'COD_INGRESO_UCN': 'LS', 
# 'DESC_INGRESO_UCN': 'IRP-Lista de selección, ', 
# 'NOMBRECARRERA': 'DERECHO', 
# 'CODIGO_SIES': None, 
# 'SEXO': 'F', 
# 'APELLIDO_MATERNO': 'HERRERO', 
# 'DURACION': '10', 
# 'PRIMER_NOMBRE': 'MONICA', 
# 'CATALOGO': '000000', 
# 'SEDE': 'A', 
# 'ANHIO_TITULO': '2003', 
# 'N_DOCUMENTO': '17327014', 
# 'SEMESTRE_INGRESO': '1', 
# 'SEMESTRES_SUSPENDIDOS': 0, 
# 'COD_INGRESO_CARRERA': 'LS', 
# 'DESC_INGRESO_CARRERA': 'IRP-Lista de selección, ', 
# 'FECHA_NACIMIENTO': '11-08-1977'}
#
def callReportLicenciadosDerecho(cookie):
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":3191,"SQLName":"mclHistAcad"}}',
                "JSONData": '{"Variables":[]}'
           })#.encode("ASCII")
    return callReport(cookie, data)

# {'FECHA_TITULO': '20-04-2017', 
# 'COD_CARRERA': '8853', 
# 'ANHIO_INGRESO': '2012', 
# 'SEGUNDO_NOMBRE': 'ANDREA', 
# 'DV': '4', 
# 'APELLIDO_PATERNO': 'ESPINOZA', 
# 'NACIONALIDAD': 'CHL', 
# 'COD_INGRESO_UCN': 'LS', 
# 'DESC_INGRESO_UCN': 'IRP-Lista de selección, ', 
# 'NOMBRECARRERA': 'LICENCIATURA EN MATEMÁTICA', 
# 'CODIGO_SIES': 'I91S1C38J1V2', 
# 'SEXO': 'F', 
# 'APELLIDO_MATERNO': 'DELGADO', 
# 'DURACION': '08', 
# 'PRIMER_NOMBRE': 'PAOLA', 
# 'CATALOGO': '201210', 
# 'SEDE': 'A', 
# 'ANHIO_TITULO': '2017', 
# 'N_DOCUMENTO': '16874521', 
# 'SEMESTRE_INGRESO': '1', 
# 'SEMESTRES_SUSPENDIDOS': 0, 
# 'COD_INGRESO_CARRERA': 'LS', 
# 'DESC_INGRESO_CARRERA': 'IRP-Lista de selección, ', 
# 'FECHA_NACIMIENTO': '09-04-1988'}
#
def callReportLicenciadosCsReligiosas_Matematicas(cookie):
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":3194,"SQLName":"mclHistAcad"}}',
                "JSONData": '{"Variables":[]}'
           })#.encode("ASCII")
    return callReport(cookie, data)

# {
# 'COD_CARRERA': '8326', 
# 'CARRERA': 'Ingeniería Comercial', 
# 'ANHO_INGRESO': '2010', 
# 'SEDE': 'Coquimbo', 
# 'SEMESTRE_INGRESO': '1', 
# 'DURACION': 10
# 'ANHO_TITULADO': '2016', 
# 'FECHA_TITULO': '2016-05-17T00:00:00.000', 
# 'SEMESTRES_SUSPENSION': '1', 
# 'SEXO': 'F', 
# 'PATERNO': 'SANHUEZA', 
# 'MATERNO': 'MUÑOZ', 
# 'NOMBRE_1': 'NATALIA', 
# 'NOMBRE_2': 'PAZ', 
# 'RUT': '17516493', 
# 'DV': '6', 
# 'CATALOGO': '201410', 
# 'CODIGO_SIES': 'I91S1C2J1V1',
#
# 'FECHA_NACIMIENTO': '1990-05-24T00:00:00.000', 
# 'NACIONALIDAD': 'Chile', 
# 'TIPO_ADMISION': 'IRP-Lista de selección, ', 
# }
#
def callReportTituladosPorYear(cookie, year):
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":2951,"SQLName":"mclAlumnos"}}',
                "JSONData": '{"Variables":[{"Value":"' + str(year) + '","Type":"WideString","Name":"ddlAnio.STVTERM_FA_PROC_YR"},{"Value":null,"Type":"WideString","Name":"ddlCarrera1.CODCARRERA"}]}'
           })#.encode("ASCII")
    return callReport(cookie, data)



#
# Retorna los programas (carreras)
#
def callODSProgramas(cookie):
    data = urllib.parse.urlencode({
                "Connection": "ODSPROD",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":3542,"SQLName":"PROGRAMA1"}}',
                "JSONData": '{"Variables":[]}'
           })#.encode("ASCII")
    return callReport(cookie, data)


#
# Retorna los RUTS de una cohorte en un programa.
# 
# programa: INGENIERÍA CIVIL EN COMPUTACIÓN E INFORMÁTICACOQUIMBO
# year: 2015
# tipo: TOTAL|ORDINARIO
# cierre: 30A|31D
#
def callODSCohortePrograma(cookie, programa, year, tipo, cierre):    
    if tipo == 'ORDINARIO' and cierre == '30A':
        data = urllib.parse.urlencode({
                        "Connection": "ODSPROD",
                        "Product": "Argos",
                        "UniqueId": '{"DataBlock":{"Id":3421,"SQLName":"MultiColumn2"}}',
                        "JSONData": '{"Variables":[{"Value":"'+str(year)+'","Type":"WideString","Name":"Cohorte.COHORTE"},{"Value":"'+str(programa)+'","Type":"WideString","Name":"PROGRAMA1.SEL"}]}'
                })
    elif tipo == 'ORDINARIO' and cierre == '31D':
        data = urllib.parse.urlencode({
                        "Connection": "ODSPROD",
                        "Product": "Argos",
                        "UniqueId": '{"DataBlock":{"Id":3421,"SQLName":"MultiColumn4"}}',
                        "JSONData": '{"Variables":[{"Value":"'+str(year)+'","Type":"WideString","Name":"Cohorte1.COHORTE"},{"Value":"'+str(programa)+'","Type":"WideString","Name":"PROGRAMA3.SEL"}]}'
                })
    elif tipo == 'TOTAL' and cierre == '30A':
        data = urllib.parse.urlencode({
                        "Connection": "ODSPROD",
                        "Product": "Argos",
                        "UniqueId": '{"DataBlock":{"Id":3422,"SQLName":"MultiColumn2"}}',
                        "JSONData": '{"Variables":[{"Value":"'+str(year)+'","Type":"WideString","Name":"Cohorte.COHORTE"},{"Value":"'+str(programa)+'","Type":"WideString","Name":"PROGRAMA1.SEL"}]}'
                })
    elif tipo == 'TOTAL' and cierre == '31D':
        data = urllib.parse.urlencode({
                        "Connection": "ODSPROD",
                        "Product": "Argos",
                        "UniqueId": '{"DataBlock":{"Id":3422,"SQLName":"MultiColumn4"}}',
                        "JSONData": '{"Variables":[{"Value":"'+str(year)+'","Type":"WideString","Name":"Cohorte1.COHORTE"},{"Value":"'+str(programa)+'","Type":"WideString","Name":"PROGRAMA3.SEL"}]}'
                })

    return callReport(cookie, data)


def callReportInscritosNRC(cookie, periodo, nrc):
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":2059,"SQLName":"mclAlumInsc"}}',
                "JSONData": '{"Variables":[{"Value":"'+str(periodo)+'","Type":"WideString","Name":"ddlPeriodo.CODIGO_PERIODO"},{"Value":"'+str(nrc)+'","Type":"WideString","Name":"mlcInfoAsig.NRC"}]}'
           })#.encode("ASCII")
    return callReport(cookie, data)

def callReportRenunciadosNRC(cookie, periodo, nrc):
    data = urllib.parse.urlencode({
                "Connection": "CONSULTA_BANNER",
                "Product": "Argos",
                "UniqueId": '{"DataBlock":{"Id":2059,"SQLName":"mclAlumRen"}}',
                "JSONData": '{"Variables":[{"Value":"'+str(periodo)+'","Type":"WideString","Name":"ddlPeriodo.CODIGO_PERIODO"},{"Value":"'+str(nrc)+'","Type":"WideString","Name":"mlcInfoAsig.NRC"}]}'
           })#.encode("ASCII")
    return callReport(cookie, data)


def start(username="155726997",password="contreras2018"):
    cookie = getSessionID()
    if cookie == None:
        print("No hay sesion")
        return None

    cookie = doAuth(cookie, username, password)
    if cookie == None:
        print("Auth error")
        return None
    return cookie

def test():
        cookie = getSessionID()
        if cookie == None:
            print("No hay sesion")
            exit()

        cookie = doAuth(cookie)
        if cookie == None:
            print("Auth error")
            exit()

        data = callReportAlumInscNrc(cookie, "201710", "12122")
        if data == None:
            print("Report error")
            exit()
        
        data = callReportAlumMatriculadosPeriodo(cookie, "201710")
        if data == None:
            print("Report error")
            exit()
        
        f = open("c:/temp/output.txt", "w")
        f.write(str(data))
        f.close()

        print("Done")
    



#print(response)
#response = response.decode("utf-8")