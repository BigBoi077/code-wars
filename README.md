# Code Wars

## Configurations

```bash
<VirtualHost *:80>
	ServerName code-wars.com

	ServerAdmin webmaster@localhost
	DocumentRoot /var/www/code-wars/public
	<Directory /var/www>
		AllowOverride All
		Require all granted
	</Directory>

	SetEnv PASSWORD_PEPPER "aPHOl9397AJuHOts7ZOj4DUMK4rC9+LuxopfSiKrvLw="

	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

Document d'équipe(https://drive.google.com/drive/folders/1YOozhvx08uR65PQ8mvOyP4IddzxBN2yB?usp=sharing)
