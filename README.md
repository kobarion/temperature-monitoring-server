# Temperature monitoring server using ESP8266 and DS18B20

[![Projeto](http://imgur.com/iJQGA2Q.png)](https://youtu.be/PxDbLtU5sy8 "Projeto")

Project for the "Project in Eletronics" course on the Eletronic Engineering program at Universidade Federal de Santa Catarina (Brazil).

## Download

1. [Download](https://github.com/kobarion/temperature-monitoring-server/releases) the latest release from GitHub.
2. [Download](http://www.usbwebserver.net/en/download.php) the latest version of USBWebserver.
3. Unzip and paste the folder `projeto` and `favicon` to the `root` folder of the USBWebserver directory.

## Setting up ESP8266 and MySQL

After getting all the prerequiring files it's time to setup ESP8266 to your existing network and create the necessary MySQL database.

1. Preparing the ESP8266 sketch.

* Open your `SQL_DS18B20.ino` file and on the following code change the fields according to your network.

```c++
const char* server = "ip";
const char* ssid = "ssid"; 
const char* password = "password";
```

* On the same file search for the `sendtemperatureTS()` function and change the hostIP. 

```c++
client.print("Host: hostIP\n");
```

2. Preparing the necessary databases for the project.

* Execute `USBWebserver` and make sure that the `Apache port` is set as `8080`.

* Open your browser and type: `localhost:8080/phpmyadmin` to open phpmyadmin.

* Acess using the default login ID `root` and the password `usbw`.

* Now you have 2 options: Start your own new database following the steps below or if you only wish to do some testing you can 
take the `.sql` file and import it.

* Create a new database called `bdprojeto`.

* Open the database and create the first table `usuarios`. On this table you will register the users.
  * Create 4 new columns named: `id`, `nome`, `usuario`, `senha`.
    * Set `id` as `INT(11)` and `AUTO_INCREMENT`;
    * Set `nome` as `VARCHAR(200)`;
    * Set `usuario` and `senha` as `VARCHAR(50)`;

* Now create the second table `dados`. On this table the sensor values are gonna be stored.
  * Create 4 new columns named: `id`, `sensor`, `temp`, `date`.
    * Set `id` as `INT(11)` and `AUTO_INCREMENT`;
    * Set `sensor` as `VARCHAR(50)`;
    * Set `temp` as `VARCHAR(10)`;
    * Set `date` as `TIMESTAMP`, `CURRENT_TIMESTAMP`, `on update CURRENT_TIMESTAMP`;
    
And now you are good to go.

## Setting up DS18B20 sensor with ESP8266

It is quite simple. There are 3 pins on the DS18B20 sensor (probe): VCC, GND, DATA.

1. Connect VCC to +3.3V and GND to the ESP8266's GND.
2. Connect DATA to pin `D4` and a `pullup resistor` of 4.7k ohms.
3. Plug USB and run the `SQL_DS18B20.ino` sketch.
4. Open `Serial Monitor` and verify if it is working properly.

## Using the server

After all the steps above, enter your browser and go to `localhost:8080/projeto`. It should redirect you to the acess page.

* Enter the user and password you created on the `usuarios` table.

The control page should open with a dynamic graph plotting current values of temperature.
On the navigation bar there is a table option where you are able to select data from a period of time. Next to the table,
there is a dropdown list named option, where you can choose which graph you wanna see.
If you wish to use a 3rd party option to analyze the data, the data server option will create a json file with all data.
