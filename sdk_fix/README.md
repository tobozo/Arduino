1) In Arduino go to `File` > `Preferences`  

2) Add `http://arduino.esp8266.com/stable/package_esp8266com_index.json` to the Additional Boards Manager URLs. (source: https://github.com/esp8266/Arduino)  

3) Go to `Tools` > `Board` > `Boards Manager` and search for `esp8266`  

4) Select version `2.0.0` and click on `Install` (**must be version 2.0.0!**)  
![selecting the right sdk](https://raw.githubusercontent.com/tobozo/Arduino/deauther/screenshots/screenshot_install_sdk.jpg)

5) Go to `File` > `Preferences` and open the folder path under `More preferences can be edited directly in the file`  
![opening path](https://raw.githubusercontent.com/tobozo/Arduino/deauther/screenshots/screenshot_select_path.jpg)

6) Replace following files:  
`platform.txt` -> `\packages\esp8266\hardware\esp8266\2.0.0\platform.txt`  

`user_interface.h` -> `\packages\esp8266\hardware\esp8266\2.0.0\tools\sdk\include`  

`ESP8266WiFi.cpp`   
`ESP8266WiFi.h` -> `\packages\esp8266\hardware\esp8266\2.0.0\libraries\ESP8266WiFi\src`  

7) Install following libraries:  

https://github.com/bblanchon/ArduinoJson  
https://github.com/ivanseidel/LinkedList  
https://github.com/squix78/esp8266-oled-ssd1306  
