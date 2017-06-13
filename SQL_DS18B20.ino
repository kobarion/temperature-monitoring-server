/************************* Bibliotecas *********************************/
#include <ESP8266WiFi.h>
#include <OneWire.h>
#include <DallasTemperature.h>
/********************** Configuração OneWire ***************************/

#define ONE_WIRE_BUS 2  // pino D4 na placa ESP8266 nodemcu V2
OneWire oneWire(ONE_WIRE_BUS);
DallasTemperature DS18B20(&oneWire);

/*********************** Variaveis Globais *****************************/

float temp;
int sent = 0;
const int postingInterval = 5; // intervalo de postagem para o servidor

/************************* Servidor **********************************/

const char* server = "ip";
/************************* Conexão WiFi*********************************/

const char* ssid = "ssid"; 
const char* password = "password";

/*************************** Setup **************************************/

void setup() {
  Serial.begin(115200);
  connectWifi();
 }

/**************************** Loop ***************************************/

void loop() {

  if (WiFi.status() != WL_CONNECTED){
    connectWifi();
  }
  
  DS18B20.requestTemperatures(); 
  if (DS18B20.getTempCByIndex(0) != 85.00){
    if (DS18B20.getTempCByIndex(0) != -127.00){
      temp = DS18B20.getTempCByIndex(0);
      sendTemperatureTS(temp);
    }   
  }
  Serial.print(String(sent)+" Temperature: ");
  Serial.println(temp);  
  int count = postingInterval;
  while(count--)
  delay(1000);

}

/******************* Implementação dos Prototypes**************************/

/* Configuração WiFi */

void connectWifi()
{
  Serial.print("Connecting to "+*ssid);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
  delay(1000);
  Serial.print(".");
  }  
  Serial.println("");
  Serial.println("Connected");
  Serial.println("");  
}//end connect

/* Envio do valor da temperatura para servidor */

void sendTemperatureTS(float temp)
{  
   WiFiClient client;
  
   if (client.connect(server, 8080)) { 
   Serial.println("WiFi Client connected ");
   
   String postStr;
   postStr += "&field1=";
   postStr += String(temp);
      
   client.print("POST /projeto/salvardados.php HTTP/1.1\n");
   client.print("Host: hostip\n");
   client.print("Connection: close\n");
   client.print("Content-Type: application/x-www-form-urlencoded\n");
   client.print("Content-Length: ");
   client.print(postStr.length());
   client.print("\n\n");
   client.print(postStr);
   delay(1000);
   
   }//end if
   sent++;
 client.stop();
}//end send
