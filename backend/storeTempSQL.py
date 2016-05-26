#****************************************************
# File: readTempSQL.py 
# Authors: Tyler Sriver, Preston Kemp
#
# This file gets the temperature from the 2 sensors and stores them in their respective tables in the mySQL 
#	temp_database 
#***************************************************
import os
import time 
import datetime 
import glob 
import MySQLdb 
from DS1620 import * 
from time import strftime
 
os.system('modprobe w1-gpio')
os.system('modprobe w1-therm')

#Variables for the Sensors
temp_sensor = '/sys/bus/w1/devices/28-0000067065c4/w1_slave' #28-0000067065c4 
temp_sensor2 = DS1620(19,13,26)

# Variables for MySQL
db = MySQLdb.connect(host="localhost", user="root",passwd="password", db="temp_database")
dbWeb = MySQLdb.connect(host="173.194.86.153", user='pi', passwd="rn4R9EfAarJpY5VwY8rnBlL2", db="temp_database") 
cur = db.cursor()
curWeb = dbWeb.cursor()

# Function to get the temperature
def tempRead():
    t = open(temp_sensor, 'r')
    lines = t.readlines()
    t.close()
    temp_output = lines[1].find('t=')
    if temp_output != -1:
        temp_string = lines[1].strip()[temp_output+2:]
        temp_c = (float(temp_string)/1000.0)*1.8+32
    return round(temp_c,1)
 
while True:
    water = tempRead()
    air = temp_sensor2.get_temperature()
    air = air * 9.0 / 5.0 + 32.0
    print water
    print air
    datetimeWrite = (time.strftime("%Y-%m-%d ") + time.strftime("%H:%M:%S"))
    print datetimeWrite

    #SQL commands to input data into tables
    sql = ("""INSERT INTO temperature (datetime,water,air) VALUES (%s,%s,%s)""",(datetimeWrite,water,air))
    
    try:
        print "Writing to database..."
        #Execute the SQL command
        cur.execute(*sql)
	curWeb.execute(*sql)
        #Commit your changes in the database
        db.commit()
	dbWeb.commit()
        print "Write Complete"
    except:
        #Rollback in case there is any error
        db.rollback()
	dbWeb.rollback()
        print "Failed writing to database"

    cur.close()
    curWeb.close()
    db.close()
    dbWeb.close()
    break
