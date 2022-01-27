# Code Wars
[![Maintainability](https://api.codeclimate.com/v1/badges/24f7d94b96d3412089fe/maintainability)](https://codeclimate.com/github/cegepst/code-wars/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/24f7d94b96d3412089fe/test_coverage)](https://codeclimate.com/github/cegepst/code-wars/test_coverage)

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
