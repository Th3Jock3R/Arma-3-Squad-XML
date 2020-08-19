# ArmA 3 Squad.XML Management

I made this small project, that you can host your own Squad.XML for ArmA 3.
Just put this on your webserver and you can edit the squad.xml

The Tool is protected with htpassword protection. The Example Login in this tool is:
```
Username: admin
Password: password
```

Change or add login credentials by edit the file .htpasswd. 
No idea how to create the credentials? You can use this tool: 
https://www.web2generators.com/apache-tools/htpasswd-generator

Past the Output in the .htpasswd and upload them to the server. Each Credential need his own line.

#### Squad Logo
Upload the Logo as PAA file and put them into the root directory (same directory like the squad.xml). Than you can select it in the editor.

#### Troubleshooting
The Squad.XML must be available with http. When you try to join a linux hosted server and use https, it will fail!
