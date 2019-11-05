import MySQLdb
from datetime import datetime
 
myconn = MySQLdb.connect("localhost","root","","doan")

cur = myconn.cursor()  

s1 = "DROP TABLE IF EXISTS location"
cur.execute(s1)
s2 = "DROP TABLE IF EXISTS router"
cur.execute(s2)
s3 = "DROP TABLE IF EXISTS sensor"
cur.execute(s3)
s4 = "DROP TABLE IF EXISTS sensordata"
cur.execute(s4)
s5 = "DROP TABLE IF EXISTS device"
cur.execute(s5)
s6 = "DROP TABLE IF EXISTS user"
cur.execute(s6)
sql1 = """create table location(id int(11) auto_increment primary key,\
										area char(255) not null,\
										parentid int(255) null,\
										mac char(255) not null,\
										des char(255) null,\
										ext char(255) null)"""
cur.execute(sql1)
sql2 = """create table router(id int(11) auto_increment primary key,\
										areaid int(255) null,\
										sensorid int(255) null,\
										active int(11) null)"""
cur.execute(sql2)
sql3 = """create table sensor(id int(11) auto_increment primary key,\
										type char(255) null,\
										code char(255) not null,\
										arange char(255) null,\
										des char(255) null,\
										icon char(255) null,\
										ext char(255) null)"""
cur.execute(sql3)
sql4 = """create table sensordata(id int(11) auto_increment primary key,\
										sensor int(255) null,\
										value int(255) null,\
										time datetime null)"""
cur.execute(sql4)
sql5 = """create table device(id int(11) auto_increment primary key,\
										areaid int(11) not null,\
										name char(255) null,\
										code char(255) null,\
										status char(255) null,\
										des char(255) null,\
										ext char(255) null)"""
cur.execute(sql5)
sql6 = """create table user(id int(11) auto_increment primary key,\
										name char(255) not null,\
										gmail char(255) not null,\
										password char(255) null,\
										address char(255) null,\
										des char(255) null,\
										ext char(255) null,\
										time datetime null)"""
cur.execute(sql6)
print('success')
 
myconn.close()
