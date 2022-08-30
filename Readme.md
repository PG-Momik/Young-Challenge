# Petroleum Report Generation
- Web Application

# Accessing the Web App through:
## Docker 
  ```
  docker pull momik88/momik-challenge-working
  ```  
- Run a container on port ' *xyz* '
- Now visit https://localhost:xyz
- API doesn't work locally using this method(I couldnt setup apache configs properly)

## XAMPP
- Download a  copy this repository
- Unzip and paste into htdocs
- Now visit https://localhost/Challenge
- API works, at https://localhost/Challenge/API/additional-params

## The php -S localhost way
- ### Requirements:
  - Machine with well configured apache, php8.0 or higher and php-pdo-mysql driver
- ### Steps
  - Download a copy this repository
  - Unzip and paste in a folder say ' *folder_X* ', such that ' *folder_X* ' is the parent ofthe unzipped ' *Challenge* ' folder
  - ```
    php -S localhost:port-number ./
    ```
  - Now visit https://localhost:port-number/Challenge
  - API works, at https://localhost:port-number/Challenge/API/additional-params

# Accessing the hosted 
- ### Documentation (baseURl) : https://youngchallenge.000webhostapp.com/
- ### Web App
    - baseUrl/WebApp
- ### API
    - baseUrl/API/additional-params
- ### DB
    - baseURl/DB/PetroliumDB.db    
- ### API calling script
    - baseURL/script.php
