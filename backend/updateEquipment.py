#
# File: updateEquipment.py
# Authors Tyler Sriver, Preston Kemp
# Created: 20 April, 2016
#
import os
import MySQLdb
import RPi.GPIO as GPIO
import time

# Disable Warnings    
GPIO.setwarnings(False)
# Set GPIO pins to outputs
GPIO.setmode(GPIO.BCM)
GPIO.setup(18, GPIO.OUT)
GPIO.setup(7, GPIO.OUT)

# Sleep upon initial run
time.sleep(60)

# Start infinite loop
while True:
    # Open Connection 
    host ="173.194.86.153"
    user ="pi"
    passwd ="rn4R9EfAarJpY5VwY8rnBlL2"
    db="equipment"
    try:
        # Try to open the connection
        db = MySQLdb.connect(host, user, passwd, db)
        cur = db.cursor()
    
        # Retrieve Status of Equipment 
        cur.execute("SELECT pump,heater FROM status ORDER BY id DESC LIMIT 1")
    
        # Update the state of the heater and pump 
        for (heater, pump) in cur:
            # Update pump
            if pump == 0:
                GPIO.output(18, 0)
            elif pump == 1:
                GPIO.output(18, 1)
            # Update Heater   
            if heater == 0:
                GPIO.output(7, 0)
            elif heater == 1:
                GPIO.output(7, 1)
                
        # Close the connection   
        cur.close()
        db.close()
    except:
        print "An error occurred" 
    time.sleep(1)
        
    
    
