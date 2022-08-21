# Petroleum Report Generation
- Web Application

## Accessing the Web App through:
## Docker 
- ```
  docker pull momik88/momik-challenge-image
  docker run -it --rm -d -p 8000:80 --name momik-challenge-container momik-challenge-image
  ```
- Now visit https://localhost/8000

## XAMPP
- Download a  copy this repository
- Unzip and paste into htdocs
- Now visit https://localhost/Challenge

## The php -S localhost way
- Download a copy this repository
- Unzip and paste in a folder say '*folder_X*', such that 'folder_X' is the parent parent the unzipped 'Challenge' folder
- ```
  php -S localhost:port_number ./
  ```
- Now visit https://localhost:port_number

## Accessing the API
- Download and Read the <u><b>index.html</b></u>file for API documentation.
- Find the publicly hosted API at base url: {i will inset 00webhost url here}

## Requirements
- Machine with apache and php8.0 or higher
- Machine with php-pdo-mysql driver
