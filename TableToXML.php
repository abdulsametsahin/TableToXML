<?php
/**
 * Abdulsamet Şahin
 * Mysql veritabınındaki tabloyu xml olarak çıkarmanızı sağlar.
 */
class TableToXML
{

  # Veritabanı bilgileri.
  private $host;
  private $user;
  private $pass;
  private $name;

  function __construct($host, $user, $pass, $name) {
       $this->host = $host;
       $this->user = $user;
       $this->pass = $pass;
       $this->name = $name;
   }

  /**
   * Veritabanı bağlantısı
   *
   * @return PDO
   */
  public function db()
  {
    return new PDO("mysql:host=$this->host;dbname=$this->name;charset=utf8", $this->user, $this->pass);
  }

  /**
   * XML Dosyasını üretir.
   *
   * @param table String: Veritabanı adı
   * @param xml_name String: Çıkış XML dosyası
   */
  public function generate($table, $xml_name, $item_name = "item")
  {
    # Dosya varsa uyarı.
    if (file_exists($xml_name)) {
      throw new \Exception($xml_name . " dosyası zaten mevcut.
      İşleme devam etmek için dosyayı siliniz yada adını değiştiriniz.", 1);
    }
    # Dosyayı oluştur.
    touch($xml_name);

    $db = $this->db();
    $rows = $db->query("SELECT * FROM $table")->fetchAll();
    $counter = 0;
    file_put_contents($xml_name, '<?xml version="1.0" encoding="UTF-8"?>', FILE_APPEND);
    file_put_contents($xml_name, '<'.$table.'>', FILE_APPEND);
    foreach ($rows as $row) {

      if (++$counter % 1000 == 0) { echo "Biraz bekleniyor...\n"; sleep(5);}

      file_put_contents($xml_name, '<'.$item_name.'>', FILE_APPEND);
      foreach ($row as $key => $value) {
        # numeric keyleri atlıyoruz.
        if (is_numeric($key)) continue;
        $value = html_entity_decode($value);
        $value = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $value);
        file_put_contents($xml_name, '<'.$key.'>'.$value.'</'.$key.'>', FILE_APPEND);
      }
      file_put_contents($xml_name, '</'.$item_name.'>', FILE_APPEND);
    }
    file_put_contents($xml_name, '</'.$table.'>', FILE_APPEND);

    return $xml_name;
  }
}
