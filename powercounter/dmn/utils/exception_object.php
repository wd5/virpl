<?php
  ////////////////////////////////////////////////////////////
  // ������ �����������������
  // 2006-2007 (C) IT-������ SoftTime (http://www.softtime.ru)
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 

  // �������� ��������� ��������
  require_once("../utils/top.php");

  echo "<p class=help>��������� �������������� 
        �������� (ExceptionObject) - ������� 
        ������������� � �������� �������� ����������
        �������, ����� �������� �� �������� 
        ����������� �� �������� ������ field.
        {$exc->getMessage()}.</p>";
  echo "<p class=help>������ � ����� {$exc->getFile()}
        � ������ {$exc->getLine()}.</p>";

  // �������� ���������� ��������
  require_once("../utils/bottom.php");
  exit();
?>