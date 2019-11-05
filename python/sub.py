import paho.mqtt.client as mqtt
from savedata import *
import MySQLdb
import random
import json
from datetime import datetime
from time import sleep

Broker = "soldier.cloudmqtt.com"
Port = 11600
Wait = 400
Topic = "datasensor"
Topic2 = "datafake"

def on_connect(client, userdata, flags, rc):
	if rc!=0:
		pass
		print('Unable connect to Broker...')
	else:
		print('Connected with Broker' + str(Broker))
	client.subscribe(Topic,0)
	client.subscribe(Topic2,0)

def on_message(client, userdata, msg):
	# print('Receiving data...')
	# print('Topic: ' + msg.topic)
	print(msg.payload)
	Sensor(msg.payload)

client = mqtt.Client()
client.username_pw_set(username = "guapvdfg", password = "k5WzGtSNWMQY")
client.on_connect = on_connect
client.on_message = on_message
client.connect(Broker, Port, Wait)

client.loop_forever()
