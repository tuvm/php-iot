import paho.mqtt.client as mqtt
import random
import json
from datetime import datetime
from time import sleep

Broker = "localhost"
Port = 1883
Wait = 45
Topic = "iot"

def on_connect(client, userdata, flags, rc):
	if rc!=0:
		pass
		print('Unable connect to Broker...')
	else:
		print('Connected with Broker' + str(Broker))

def on_publish(client, userdata, mid):
	pass

def disconnect(client, userdata, rc):
	if rc != 0:
		pass

mqttc = mqtt.Client()
mqttc.username_pw_set(username = "xukiijqw", password = "McQhmmD2eEJ2")
mqttc.on_connect = on_connect
mqttc.disconnect = disconnect
mqttc.on_publish = on_publish
mqttc.connect(Broker, Port, Wait)

def pub2topic(topic, message):
	mqttc.publish(topic, message)
	print('Published: ' + str(message) + '' +'on MQTT topic ' + str(topic))
	print('')

def pub_data_fake(namesensor):
	print('Nhap dia chi:')
	ssarea = input()
	print('Nhap ten du lieu:')
	ssdata = input()
	print('Nhap gia tri:')
	value = input()
	sensor_data = {}
	sensor_data['area'] = ssarea;
	sensor_data['type'] = ssdata;
	sensor_data['value'] = int(value);
	sensor_json_data = json.dumps(sensor_data)
	print('Publishing data fake from %s:' %namesensor)
	pub2topic(Topic, sensor_json_data)

while True:
	pub_data_fake('esp1')