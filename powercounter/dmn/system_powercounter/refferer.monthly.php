<?php
  ////////////////////////////////////////////////////////////
  // ������� ����� ������������ ����� - PowerCounter
  // 2003-2008 (C) IT-������ SoftTime (http://www.softtime.ru)
  // ���������: http://www.softtime.ru/forum/
  // �������� �.�. (simdyanov@softtime.ru)
  // �������� �.�. (kuznetsov@softtime.ru)
  // ����� �.� (loki_angel@mail.ru)
  // ������� �.�. (softtime@softtime.ru)
  ////////////////////////////////////////////////////////////
  // ���������� ������� ��������� ������ 
  // (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 
  // ������������� ���������� � ����� ������
  require_once("config.php");
  // ���������� SoftTime FrameWork
  require_once("../../config/class.config.dmn.php");
  // ���������� ���� �����������
  require_once("../utils/security_mod.php");
  // ���������� ���� ����������� ������ � ���� ��������
  require_once("../utils/utils.print_page.php");
  // ������������ ���������
  require_once("../utils/utils.pager.php");
  // ������������ WHERE-�������
  require_once("utils.where.php");
  // ���������� �������
  require_once("utils.query_result.php");

  // ������ ���������� ���������� �������� �������� � ���������.
  $title = '���������� �����'; 
  try
  {
    // �������� ��������� ��������
    require_once("../utils/topcounter.php");

    // ������������ ���������
    if(empty($_GET['page'])) $page = 1;
    else $page = $_GET['page'];

    // ��������� ���������� �������
    $query = "SELECT COUNT(DISTINCT putdate) 
              FROM $tbl_arch_refferer_month";
    $total = query_result($query);

    $page_link = 3;
    $first = ($page - 1)*$pnumber;
  
    // ������� ������ �� ������ ��������
    pager($page, 
          $total, 
          $pnumber, 
          $page_link, 
          "");
    echo "<br><br>";

    // ��������� ������ ��� ������� ��������
    $query = "SELECT UNIX_TIMESTAMP(putdate) as putdate
              FROM $tbl_arch_refferer_month
              GROUP BY putdate
              ORDER BY putdate DESC
              LIMIT $first, $pnumber";
    $arh = mysql_query($query);
    if(!$arh)
    {
       throw new ExceptionMySQL(mysql_error(), 
                                $query,
                               "������ ���������� �������� ����������");
    }
    if(mysql_num_rows($arh))
    {
      echo "<table class=table width=100% border=0 cellpadding=0 cellspacing=0>
              <tr class=header align=center>
                <td align=center width=50%>����</td>
                <td align=center width=50%>������</td>
              </tr>";
      while($hits = mysql_fetch_array($arh))
      {
        // ��������� ����
        $date_table = date("Y.m",$hits['putdate']);
        echo "<tr>
                <td align=center>$date_table</td>
                <td align=center><a href=$_SERVER[PHP_SELF]?date=$hits[putdate]>��������</a></td>
              </tr>";
      }
      echo "</table><br><br>";
    }

    // ���� �������� $_GET['date'] �� ����, ����������� IP-������
    // �� ���� ����
    if(!empty($_GET['date']))
    {
      $_GET['date'] = intval($_GET['date']);
      $query = "SELECT * FROM $tbl_arch_refferer_month 
                WHERE putdate LIKE '".date("Y-m-d",$_GET['date'])."%'";
      $ipt = mysql_query($query);
      if(!$ipt)
      {
         throw new ExceptionMySQL(mysql_error(), 
                                  $query,
                                 "������ ���������� �������� ����������");
      }
      if(mysql_num_rows($ipt))
      {
        echo "<table class=table width=100% border=0 cellpadding=0 cellspacing=0>
                <tr class=header align=center>
                  <td>�������</td>
                  <td>����� ���������</td>
                </tr>";
        while($refferer = mysql_fetch_array($ipt))
        {
          echo "<tr><td>".htmlspecialchars($refferer['name'])."</td>";
          echo "<td>$refferer[total]</td></tr>";
        }
        echo "</table>";
      }
    }

    // ���������� ��������
    require_once("../utils/bottomcounter.php");
  }
  catch(ExceptionObject $exc) 
  {
    require("../utils/exception_object.php"); 
  }
  catch(ExceptionMySQL $exc)
  {
    require("../utils/exception_mysql.php"); 
  }
  catch(ExceptionMember $exc)
  {
    require("../utils/exception_member.php"); 
  }
?>