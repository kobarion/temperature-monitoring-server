/************************* Bibliotecas *********************************/
#include <ESP8266WiFi.h>
#include <OneWire.h>
#include <DallasTemperature.h>
/********************** Configuração OneWire ***************************/

#define ONE_WIRE_BUS 2  // pino D4 na placa ESP8266 nodemcu V2
OneWire oneWire(ONE_WIRE_BUS);
DallasTemperature DS18B20(&oneWire);

/*********************** Variaveis Globais *****************************/
int ledPin = 5; //GPIO 5 (D1)
int ledBlink = 4; //GPIO 4 (D2)
int ledBlink1 = 13; //GPIO 13 (D7)
float temp;
int sent = 0;
const int postingInterval = 5; // intervalo de postagem para o servidor

/************************* Servidor **********************************/

const char* server = "server";
/************************* Conexão WiFi*********************************/

const char* ssid = "ssid"; 
const char* password = "password";

/*************************** Setup **************************************/

void setup() {
  Serial.begin(115200);
  pinMode(ledPin, OUTPUT);
  pinMode(ledBlink, OUTPUT);
  pinMode(ledBlink1, OUTPUT);
  digitalWrite(ledPin,LOW);
  digitalWrite(ledBlink,LOW);
  digitalWrite(ledBlink1,LOW);
  delay(10);
  analogWrite(ledPin, 255);
  connectWifi();
 }

/**************************** Loop ***************************************/

void loop() {

  if (WiFi.status() != WL_CONNECTED){
    connectWifi();    
  }
  analogWrite(ledBlink1,0);
  
  int count = postingInterval;
  while(count--)
  delay(1000);
  
  DS18B20.requestTemperatures(); 

  if (DS18B20.getTempCByIndex(0) != 85.00){
    if (DS18B20.getTempCByIndex(0) != -127.00){
      temp = DS18B20.getTempCByIndex(0);
      sendTemperature(temp);
    }   
  }
  Serial.print(String(sent)+" Temperature: ");
  Serial.println(temp);
}

/******************* Implementação das Funções **************************/

/* Configuração WiFi */

void connectWifi()
{
  Serial.print("Connecting to "+*ssid);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    analogWrite(ledBlink1,0);
    delay(500);
    analogWrite(ledBlink1,255);
    delay(500);
    Serial.print(".");
  }  
  Serial.println("");
  Serial.println("Connected");
  Serial.println("");  
}//end connect

/* Envio do valor da temperatura para servidor */

void sendTemperature(float temp)
{  
   WiFiClient client;
  
   if (client.connect(server, 8080)) { 
   Serial.println("WiFi Client connected ");
   
   String postStr;
   postStr += "field1=";
   postStr += String(temp);
               
   client.print("POST /projeto/salvardados.php HTTP/1.1\n");
   client.print("Host: hostIP\n");
   client.print("Connection: close\n");
   client.print("Content-Type: application/x-www-form-urlencoded\n");
   client.print("Content-Length: ");
   client.print(postStr.length());
   client.print("\n\n");
   client.print(postStr);
   analogWrite(ledBlink,255);
   delay(300);
   analogWrite(ledBlink,0);
   }//end if
   sent++;
 client.stop();
}//end send