#
# File: deleteRows.py
# Authors Tyler Sriver, Preston Kemp
# Created: 20 April, 2016
#
import os
import time
import datetime
import glob
import MySQLdb
from time import strftime
from datetime import timedelta
from datetime import date

# Open Connection to database
db = MySQLdb.connect(host="173.194.86.153", user="pi", passwd="rn4R9EfAarJpY5VwY8rnBlL2", db="temp_database")
cur = db.cursor()

# Get the curent time stamp
today = datetime.datetime.now()

try: 
    # Query the last temperature inputed in the database
    cur.execute("""SELECT id FROM temperature ORDER BY id DESC LIMIT 1""")
    # optain the id number
    idCurrent = cur.fetchone()[0]
    
    # Remove all entries over 8000 old
    cur.execute("""DELETE FROM temperature WHERE id < (%s - %s)""", (idCurrent,8000))
    
    db.commit()
except:
	print "An error occured in: deleteRows.py"
  
finally:
    # Close the connection
	cur.close()
	db.close()
