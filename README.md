# Mysql Table To XML File
This PHP class allow you to export  table into an xml.

## Usage

    include "./TableToXML.php";
    
    $ttx = new TableToXML("db_host", "db_user", "pass", "db_name");
    
    $ttx->generate("table_name", "./products.xml", "product");
    

>  **./products.xml** file will be generated if you run these codes.
>  If the given xml file exists, you will get an error. 
