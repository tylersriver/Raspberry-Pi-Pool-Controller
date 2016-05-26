#
# File: scheduler.py
# Authors: Tyler Sriver, Preston Kemp
# Created: 5 April, 2016
#

import os
import time
import datetime
import MySQLdb

# Wait to start the program on boot
time.sleep(60)

while True:
    # Initiate Database Connection
    host ="173.194.86.153"
    user ="pi"
    passwd ="rn4R9EfAarJpY5VwY8rnBlL2"
    db="equipment"
    tempdb="temp_database"
    try:
        # Conect to database
        db = MySQLdb.connect(host, user, passwd, db)
        tempCon = MySQLdb.connect(host, user, passwd, tempdb)
        # Open cursors for multiple MySQL queries
        cur = db.cursor()
        cur2 = db.cursor()
        cur3 = db.cursor()
        cur4 = db.cursor()
        tempCur = tempCon.cursor()

        # Get Current Weekday/Time/datetime
        today = datetime.datetime.today().weekday()
        current = datetime.datetime.today()
        print current
        currentTime = datetime.datetime.now().time()
        now = datetime.datetime.now()
        midnight = now.replace(hour=0, minute=0, second=0, microsecond=0)
        seconds = (now - midnight).seconds
        print(seconds)
        
        # Get current Water Temperature
        tempCur.execute("""SELECT water from temperature ORDER BY id DESC LIMIT 1""")
        waterTemp = tempCur.fetchone()[0]
        print waterTemp

        # Get Schedule Entries From Database
        cur.execute("""SELECT start, stop, tempSetting FROM schedule WHERE day=%s""",(today))
        cur2.execute("""SELECT interrupt FROM settings""")
        interrupt = cur2.fetchone()[0]
        
        cur3.execute("""SELECT pump FROM status ORDER BY id DESC LIMIT 1""")
        pump = cur3.fetchone()[0]
        print pump
        cur4.execute("""SELECT heater FROM status ORDER BY id DESC LIMIT 1""")
        heater = cur4.fetchone()[0]
        print heater
        

        # Use Schedule times to set / check status of pump / heater
        for (start, stop, tempSetting) in cur:
            print interrupt
            print tempSetting
            if interrupt == 0 and (start.total_seconds()<=seconds and stop.total_seconds()>=seconds):
                if (pump == 0 and heater == 0) and waterTemp < (tempSetting - 2):
                    cur.execute("""INSERT INTO status (datetime, pump, heater) VALUES (%s,%s,%s)""", (current, 1 , 1))
                elif (pump == 1 and heater == 1) and waterTemp >= (tempSetting + 2):
                    cur.execute("""INSERT INTO status (datetime, pump, heater) VALUES (%s,%s,%s)""", (current, 1 , 0))
                elif (pump == 1 and heater == 0) and waterTemp < (tempSetting - 2):
                    cur.execute("""INSERT INTO status (datetime, pump, heater) VALUES (%s,%s,%s)""", (current, 1 , 1))
                elif (pump == 0 and heater == 0) and waterTemp > (tempSetting - 2):
                    cur.execute("""INSERT INTO status (datetime, pump, heater) VALUES (%s,%s,%s)""", (current, 1 , 0))
            elif interrupt == 0 and (start.total_seconds>seconds or stop.total_seconds<seconds):
                if pump == 1:
                    cur.execute("""INSERT INTO status (datetime, pump, heater) VALUES (%s,%s,%s)""", (current, 0 , 0))
                    
            

        # Changes by Preston
        db.commit() #commit changes in database
        print(cur._last_executed) #print out the query that was executed
        print(tempCur._last_executed)
        # End Changes by Preston

        cur.close()
        cur2.close()
        db.close()
    except:
        print "An error occured"    
    time.sleep(10)















