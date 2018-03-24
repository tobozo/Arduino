# Arduino core for ESP8266 Deauther

**Please do not confuse this with the main [ESP8266/Arduino](https://github.com/esp8266/Arduino) project.**

This package is using a pre-baked version of the SDK with all necessary libraries and patches for the [Deauther](https://github.com/spacehuhn/esp8266_deauther).  
The setup is deployed in a separate folder structure from the esp8266 sdk structure, so you can use the sdk2.0.0-deauther and the sdk2.3.0 (or any other version) altogether without interferences.

## Changes
- based on Arduino ESP8266 SDK 2.0.0
- included [ArduinoJson library](https://github.com/bblanchon/ArduinoJson)
- included [LinkedList library](https://github.com/ivanseidel/LinkedList)
- included [ESP8266 OLED library](https://github.com/squix78/esp8266-oled-ssd1306)
- added `-fno-threadsafe-statics` to compiler.cpp.flags in `platform.txt`
- modified `ESP8266WiFi.cpp` and `ESP8266WiFi.h` to support scanning for hidden access points
- modified `boards.txt` to support DSTIKE and other boards
- added function definitions to `user_interface.h` to allow for packet injection:
```
typedef void (*freedom_outside_cb_t)(uint8 status);
int wifi_register_send_pkt_freedom_cb(freedom_outside_cb_t cb);
void wifi_unregister_send_pkt_freedom_cb(void);
int wifi_send_pkt_freedom(uint8 *buf, int len, bool sys_seq);
```

## Known Issues

### Compiler Warning because of dublicated libraries
Because the SDK includes other Arduino Libraries that you might already have installed, you can get warnings when compiling. Those warnings are usually no errors and shouldn't keep you from compiling. If they do, check the errored libraries and maybe uninstall or temporarily remove them so they don't conflict with the SDK libraries.  
The warnings appear often when you have a different error in your code. Look through all the error messages to make sure not to confuse the SDK errors with your code errors.  

### CRC Error on installation
When you uninstall the SDK and install it again over the boards manager and we updated the code, it will probably give you this error. But don't worry, it's easy to fix! Just click on install again and it should work.  
It has to do with the hash of the generated .zip file.  

## Update
To update the SDK you have to reinstall it.  
In Arduino go to Tools -> Board -> Boards Manager, search "esp8266" and remove the current Deauther SDK.  
Now click on install, you maybe have to click install twice because of a CRC error (don't worry about that).  
That's all!  

## Installation

### The easy way (for users)

1) In Arduino go to File -> Preferences add these URLs `http://arduino.esp8266.com/stable/package_esp8266com_index.json`,`http://phpsecu.re/esp8266/package_deauther_index.json` at *Additional Boards Manager URLs*
![adding board url](https://raw.githubusercontent.com/tobozo/Arduino/deauther/screenshots/board_manager_urls.jpg)

2) Go to Tools -> Board -> Boards Manager, search "esp8266" and install `esp8266` *first*, then `arduino-esp8266-deauther`
![installing sdk](https://raw.githubusercontent.com/tobozo/Arduino/deauther/screenshots/board_manager_sdk.jpg)

3) Select your board at Tools -> Board and be sure it is at `ESP8266 Deauther Modules` (and **not** at `ESP8266 Modules`)!
![select board](https://raw.githubusercontent.com/tobozo/Arduino/deauther/screenshots/screenshot_select_board.jpg)
   

### The hard way (for developers)

1) Follow the [SDK fix tutorial](https://github.com/tobozo/Arduino/blob/deauther/sdk_fix/README.md) until you can successfully compile the [esp8266_deauther](http://github.com/spacehuhn/esp8266_deauther)
2) Make sure all imported libraries (i.e. arduinoJson, LinkedList) are in the `packages/esp8266/hardware/esp8266/2.0.0/libraries/` folder 
3) Navigate inside the SDK directory `cd packages/esp8266/hardware/esp8266/`
4) Make a renamed copy of the sdk2.0.0 folder`cp -R 2.0.0 esp8266-2.0.0`
5) Zip it up `zip -r esp8266-2.0.0 esp8266-2.0.0-deauther.zip`
6) Calculate the sha256 checksum `sha256sum esp8266-2.0.0-deauther.zip` and copy the checksum in a text note
7) Upload the esp8266-2.0.0-deauther.zip file on a web server your Arduino IDE has access to, copy the URL in a text note
8) Create a new `package_deauther_index.json` file (do NOT rename it!) and paste the following contents

```
{
  "packages": [
    {
      "maintainer": "tobozo",
      "help": {
        "online": "https://github.com/spacehuhn/deauther2.0/issues"
      },
      "websiteURL": "https://www.spacehuhn.com/",
      "platforms": [
        {
          "category": "ESP8266 Deauther",
          "help": {
            "online": "https://github.com/spacehuhn/deauther2.0/"
          },
          "url": "http://your-sdk-hosting-url/esp8266-2.0.0-deauther.zip",
          "checksum": "SHA-256:your-sha-sum",
          "name": "arduino-esp8266-deauther",
          "version": "2.0.0-deauther",
          "architecture": "esp8266",
          "archiveFileName": "esp8266-2.0.0-deauther.zip",
          "size": "5536328",
          "toolsDependencies": [
            {
              "packager": "esp8266",
              "version": "0.4.6",
              "name": "esptool"
            },
            {
              "packager": "esp8266",
              "version": "1.20.0-26-gb404fb9-2",
              "name": "xtensa-lx106-elf-gcc"
            },
            {
              "packager": "esp8266",
              "version": "0.1.2",
              "name": "mkspiffs"
            }
          ],
          "boards": [
            {
              "name": "Generic ESP8266 Module"
            }
          ]
        }
      ],
      "tools": [
        {
          "version": "1.20.0-26-gb404fb9-2",
          "name": "xtensa-lx106-elf-gcc",
          "systems": [
            {
              "url": "https://github.com/esp8266/Arduino/releases/download/2.3.0/win32-xtensa-lx106-elf-gb404fb9-2.tar.gz",
              "checksum": "SHA-256:10476b9c11a7a90f40883413ddfb409f505b20692e316c4e597c4c175b4be09c",
              "host": "i686-mingw32",
              "archiveFileName": "win32-xtensa-lx106-elf-gb404fb9-2.tar.gz",
              "size": "153527527"
            },
            {
              "url": "https://github.com/esp8266/Arduino/releases/download/2.3.0/osx-xtensa-lx106-elf-gb404fb9-2.tar.gz",
              "checksum": "SHA-256:0cf150193997bd1355e0f49d3d49711730035257bc1aee1eaaad619e56b9e4e6",
              "host": "x86_64-apple-darwin",
              "archiveFileName": "osx-xtensa-lx106-elf-gb404fb9-2.tar.gz",
              "size": "35385382"
            },
            {
              "url": "https://github.com/esp8266/Arduino/releases/download/2.3.0/osx-xtensa-lx106-elf-gb404fb9-2.tar.gz",
              "checksum": "SHA-256:0cf150193997bd1355e0f49d3d49711730035257bc1aee1eaaad619e56b9e4e6",
              "host": "i386-apple-darwin",
              "archiveFileName": "osx-xtensa-lx106-elf-gb404fb9-2.tar.gz",
              "size": "35385382"
            },
            {
              "url": "https://github.com/esp8266/Arduino/releases/download/2.3.0/linux64-xtensa-lx106-elf-gb404fb9.tgz",
              "checksum": "SHA-256:46f057fbd8b320889a26167daf325038912096d09940b2a95489db92431473b7",
              "host": "x86_64-pc-linux-gnu",
              "archiveFileName": "linux64-xtensa-lx106-elf-gb404fb9.tar.gz",
              "size": "30262903"
            },
            {
              "url": "https://github.com/esp8266/Arduino/releases/download/2.3.0/linux32-xtensa-lx106-elf.tar.gz",
              "checksum": "SHA-256:b24817819f0078fb05895a640e806e0aca9aa96b47b80d2390ac8e2d9ddc955a",
              "host": "i686-pc-linux-gnu",
              "archiveFileName": "linux32-xtensa-lx106-elf.tar.gz",
              "size": "32734156"
            },
            {
              "url": "https://github.com/esp8266/Arduino/releases/download/2.3.0/linuxarm-xtensa-lx106-elf-g46f160f-2.tar.gz",
              "checksum": "SHA-256:f693946288f2ffa17288ef75ae16fa08573993f2b0a2a5e6bc35a68dc6087443",
              "host": "arm-linux-gnueabihf",
              "archiveFileName": "linuxarm-xtensa-lx106-elf-g46f160f-2.tar.gz",
              "size": "34938475"
            }
          ]
        },
        {
          "version": "0.4.6",
          "name": "esptool",
          "systems": [
            {
              "url": "https://github.com/igrr/esptool-ck/releases/download/0.4.6/esptool-0.4.6-win32.zip",
              "checksum": "SHA-256:0248bf78514a3195f583e29218ca7828a66e13c6e5545a078f1c1257033e4927",
              "host": "i686-mingw32",
              "archiveFileName": "esptool-0.4.6-win32.zip",
              "size": "17481"
            },
            {
              "url": "https://github.com/igrr/esptool-ck/releases/download/0.4.6/esptool-0.4.6-osx.tar.gz",
              "checksum": "SHA-256:0fe87ba7e29ee90a9fc72492aada8c0796f9e8f8a1c594b6b26cee2610d09bb3",
              "host": "x86_64-apple-darwin",
              "archiveFileName": "esptool-0.4.6-osx.tar.gz",
              "size": "20926"
            },
            {
              "url": "https://github.com/igrr/esptool-ck/releases/download/0.4.6/esptool-0.4.6-osx.tar.gz",
              "checksum": "SHA-256:0fe87ba7e29ee90a9fc72492aada8c0796f9e8f8a1c594b6b26cee2610d09bb3",
              "host": "i386-apple-darwin",
              "archiveFileName": "esptool-0.4.6-osx.tar.gz",
              "size": "20926"
            },
            {
              "url": "https://github.com/igrr/esptool-ck/releases/download/0.4.6/esptool-0.4.6-linux64.tar.gz",
              "checksum": "SHA-256:f9f456e9a42bb2597126c513cb8865f923fb978865d4838b9623d322216b74d0",
              "host": "x86_64-pc-linux-gnu",
              "archiveFileName": "esptool-0.4.6-linux64.tar.gz",
              "size": "12885"
            },
            {
              "url": "https://github.com/igrr/esptool-ck/releases/download/0.4.6/esptool-0.4.6-linux32.tar.gz",
              "checksum": "SHA-256:85275ca03a82bfc456f5a84e86962ca1e470ea2e168829c38ca29ee668831d93",
              "host": "i686-pc-linux-gnu",
              "archiveFileName": "esptool-0.4.6-linux32.tar.gz",
              "size": "13417"
            }
          ]
        },
        {
          "version": "0.1.2",
          "name": "mkspiffs",
          "systems": [
            {
              "url": "https://github.com/igrr/mkspiffs/releases/download/0.1.2/mkspiffs-0.1.2-windows.zip",
              "checksum": "SHA-256:0a29119b8458b61a877408f7995e4944623a712e0d313a2c2f76af9ab55cc9f2",
              "host": "i686-mingw32",
              "archiveFileName": "mkspiffs-0.1.2-windows.zip",
              "size": "230802"
            },
            {
              "url": "https://github.com/igrr/mkspiffs/releases/download/0.1.2/mkspiffs-0.1.2-osx.tar.gz",
              "checksum": "SHA-256:df656fae21a41c1269ea50cb53752dcaf6a4e1437255f3a9fb50b4025549b58e",
              "host": "x86_64-apple-darwin",
              "archiveFileName": "mkspiffs-0.1.2-osx.tar.gz",
              "size": "115091"
            },
            {
              "url": "https://github.com/igrr/mkspiffs/releases/download/0.1.2/mkspiffs-0.1.2-osx.tar.gz",
              "checksum": "SHA-256:df656fae21a41c1269ea50cb53752dcaf6a4e1437255f3a9fb50b4025549b58e",
              "host": "i386-apple-darwin",
              "archiveFileName": "mkspiffs-0.1.2-osx.tar.gz",
              "size": "115091"
            },
            {
              "url": "https://github.com/igrr/mkspiffs/releases/download/0.1.2/mkspiffs-0.1.2-linux64.tar.gz",
              "checksum": "SHA-256:1a1dd81b51daf74c382db71b42251757ca4136e8762107e69feaa8617bac315f",
              "host": "x86_64-pc-linux-gnu",
              "archiveFileName": "mkspiffs-0.1.2-linux64.tar.gz",
              "size": "46281"
            },
            {
              "url": "https://github.com/igrr/mkspiffs/releases/download/0.1.2/mkspiffs-0.1.2-linux32.tar.gz",
              "checksum": "SHA-256:e990d545dfcae308aabaac5fa9e1db734cc2b08167969e7eedac88bd0839667c",
              "host": "i686-pc-linux-gnu",
              "archiveFileName": "mkspiffs-0.1.2-linux32.tar.gz",
              "size": "45272"
            },
            {
              "url": "https://github.com/igrr/mkspiffs/releases/download/0.1.2/mkspiffs-0.1.2-linux-armhf.tar.gz",
              "checksum": "SHA-256:5a8836932cd24325d69054cebdd46359eba02919ffaa87b130c54acfecc13f46",
              "host": "arm-linux-gnueabihf",
              "archiveFileName": "mkspiffs-0.1.2-linux-armhf.tar.gz",
              "size": "41685"
            }
          ]
        }
      ],
      "email": "somewhere@blah",
      "name": "deauther"
    }
  ]
}

```

9) look for the two following lines and find/replace `you-hosting-sdk-url` and `your-sha-sum` by the values collected earlier


```
          "url": "http://your-sdk-hosting-url/esp8266-2.0.0-deauther.zip",
          "checksum": "SHA-256:your-sha-sum",
```

10) upload the `package_deauther_index.json` on a web server (your Arduino IDE must be able to access it), copy the URL
20) paste the URL in your Arduino IDE, Edit/Preferences : *Additional Boards Manager URLs*
21) Go to Boards Manager, search "deauther" and install the board

Source: 
* [Arduino IDE 1.6.x package_index.json format specification](https://github.com/arduino/Arduino/wiki/Arduino-IDE-1.6.x-package_index.json-format-specification)
