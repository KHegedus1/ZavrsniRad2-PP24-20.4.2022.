<?php
  
  if($_SERVER['SERVER_ADDR']==='127.0.0.1'){
      $url = 'http://zavrsni2.xyz/';
      $dev = true;
      $baza = [
          'server'=>'localhost',
          'baza'=>'zavrsniRadPP24',
          'korisnik'=>'Hegedus',
          'lozinka'=>'Hegedus'
      ];
  }else{
      $url = 'https://www.polaznik21.edunova.hr/';
      $dev = false;
      $baza = [
          'server'=>'localhost',
          'baza'=>'furije_webshop',
          'korisnik'=>'furije_webshop',
          'lozinka'=>'=y5}UAK.9h@('
      ];
  }
  
  return [
      'dev'=>$dev,
      'url'=>$url,
      'rps'=>10,
      'naslovApp'=>'zavrsniRadPP24',
      'baza'=>$baza
  ];