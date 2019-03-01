import sys
import argos
import psycopg2

cookie = argos.start()
if cookie == None:
	print("No hay sesion")
	exit()

dsn="dbname=%s user=%s password=%s host=%s" % ("derivaciones_db", "derivaciones_user", "noceejif2802oicdwkcapmcsjoicej0e2iocwocdncd", "cin.ucn.cl")
conn = psycopg2.connect(dsn)
cursor = conn.cursor()

#cursor.execute("select * from student")
#for e in cursor:
#        print(e)
#exit(0)

sqlInsertEstudiante = """
	insert into student (run, name, mail, academic_level, income_year)
	values (%s, %s, %s, %s, %s)
"""
sqlInsertCarrera = """
	insert into carrer (cod_carrer, name, active)
	values (%s, %s, true)
"""
sqlInsertCarreraStudent = """
	insert into carrer_student (run, cod_carrer)
	values (%s, %s)
"""
	
periodo = '201910'

def extraerNivel(nivel):
	if nivel == "MALLA COMPLETA":	return 97
	if nivel == "EGRESADO":	return 98
	if nivel == "TITULADO":	return 99
	if nivel is None: return 0
# '8453-S06'
	partes = nivel.split("-")
	n = int(partes[1][1:], 10)
	return n

carreras = argos.callReportListaCarreras(cookie)

for carrera in carreras:
	print("Estudiantes carrera", carrera) #CODCARRERA NOMCARRERA 
	
	try:
		dato = (carrera['CODCARRERA'], carrera['NOMCARRERA'])
		cursor.execute(sqlInsertCarrera, dato)
		conn.commit()
	except psycopg2.IntegrityError:
		conn.rollback()
	
	estudiantes = argos.callReportEstudiantesCarreraEstado(cookie, periodo, carrera['CODCARRERA'], 'M')

	for e in estudiantes:
		print(e['RUT'], end=".")
		
		ingreso = int(e['ADMISION'][:4])
		dato = (e['RUT'], e['NOMBRE'], e['EMAIL'], extraerNivel(e['NIVEL_CURRICULAR']), ingreso)
		try:
			cursor.execute(sqlInsertEstudiante, dato)
			conn.commit()
		except psycopg2.IntegrityError:
			conn.rollback()


		dato = (e['RUT'], carrera['CODCARRERA'])
		try:
			cursor.execute(sqlInsertCarreraStudent, dato)
			conn.commit()
		except psycopg2.IntegrityError:
			conn.rollback()
	print()

cursor.close()
conn.close()
	
