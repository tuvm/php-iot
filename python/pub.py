import paho.mqtt.client as mqtt
import random
import json
from datetime import datetime
from time import sleep

Broker = "soldier.cloudmqtt.com"
Port = 11600
Wait = 50
Topic = "datafake"

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
mqttc.username_pw_set(username = "guapvdfg", password = "k5WzGtSNWMQY")
mqttc.on_connect = on_connect
mqttc.disconnect = disconnect
mqttc.on_publish = on_publish
mqttc.connect(Broker, Port, Wait)

def pub2topic(topic, message):
	mqttc.publish(topic, message)
	print('Published: ' + str(message) + '' +'on MQTT topic ' + str(topic))
	print('')

def pub_data_fake(namesensor):
	mac = int(random.uniform(0,5))
	macadd = ['AAAA','BBBB', 'CCCC', 'DDDD', 'EEEE']
	#Sprint(ssarea[1])
	code = int(random.uniform(0,5))
	typecode = ['temp', 'hum', 'dust', 'light','rain']
	for i in range(0,5):
		value = [int(random.uniform(20, 50)),int(random.uniform(40, 95)),int(random.uniform(500, 1000)),int(random.uniform(500, 1023)),int(random.uniform(50, 200))];
		sensor_data = {};
		sensor_data['mac'] = macadd[i];
		sensor_data['code'] = typecode;
		sensor_data['value'] = value;
		sensor_json_data = json.dumps(sensor_data)
		print('Publishing data fake from %s:' %namesensor)
		pub2topic(Topic, sensor_json_data)

while True:
	pub_data_fake('Fake')
	sleep(5)
