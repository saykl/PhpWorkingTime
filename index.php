<?php

/*
** htmlSQL - Example 1
**
** Shows a simple query
*/

include_once("htmlSQL/snoopy.class.php");
include_once("htmlSQL/htmlsql.class.php");
$wsql = new htmlsql();
$post = new htmlsql();
// connect to a file
if (!$wsql->connect('url', 'http://192.168.1.7//worktime/inoffice/worktime.krista.ru/employee/reports/inoffice.aspx.html')) {
    print 'Error while connecting: ' . $wsql->error;
    exit;
}

/* execute a query:

   This query extracts all links from the document
   and just returns href (as url) and text
*/
// WHERE $href ==
if (!$wsql->query('SELECT href as url,  text as text FROM a ')) {
    print "Query error: " . $wsql->error;
    exit;
}

// show results:
$itsURL = false;
$countTime = 0;
foreach ($wsql->fetch_array() as $row) {
    $url = 'http://worktime.krista.ru/layout.aspx?obj=Employee&amp;id=1519';

    if (strcasecmp($row['url'], $url) == 0) {
        $itsURL = TRUE;
        print "Link-URL: " . $row['url'] . "\n";
        print "Link-Text: " . trim($row['text']) . "\n\n";
    }

    /* if ((trim($row['text']) != '') and ($row['url'] != '')) {
         $itsURL = FALSE;
     }*/
    if ($itsURL == TRUE) {
        $countTime++;
    }
    if (($url <> $row['url']) and ($row['url'] <> '')) {
        $countTime = 0;
    }
    if ((trim($row['text']) != '') and ($row['url'] == '') and ($countTime > 0)) {
        if ($countTime % 2 == 0) {
            print "Вход: " . trim($row['text']) . "\n\n";
        } else {
            print "Выход: " . trim($row['text']) . "\n\n";
        }

        if ($countTime == 2) {
            if (!$post->connect('url', 'http://192.168.1.7:8087/set/javascript.0.Office.Ksusha.In?value=' . trim($row['text']) . '&prettyPrint')) {
                print 'Error while connecting: ' . $post->error;
                exit;
            }
        }

        if ($countTime  == 3) {
            if (!$post->connect('url', 'http://192.168.1.7:8087/set/javascript.0.Office.Ksusha.out?value=' . trim($row['text']) . '&prettyPrint')) {
                print 'Error while connecting: ' . $post->error;
                exit;
            }
        }


        if ($countTime  == 4) {
            if (!$post->connect('url', 'http://192.168.1.7:8087/set/javascript.0.Office.Ksusha.In2?value=' . trim($row['text']) . '&prettyPrint')) {
                print 'Error while connecting: ' . $post->error;
                exit;
            }
        }


        if ($countTime  == 5) {
            if (!$post->connect('url', 'http://192.168.1.7:8087/set/javascript.0.Office.Ksusha.Out2?value=' . trim($row['text']) . '&prettyPrint')) {
                print 'Error while connecting: ' . $post->error;
                exit;
            }
        }


        $countTime++;
        $itsURL = false;
    }

    /* if ($countTime % 2 == 0) {
         echo 'Число чётное';
     } else {
         echo 'Число нечётное';
     }*/



    // $sURL = "http://192.168.1.7:8087/set/javascript.0.Office.Ksusha.In?value=21:00&prettyPrint"; // URL-адрес POST

   /* if (!$post->connect('url', 'http://192.168.1.7:8087/set/javascript.0.Office.Ksusha.In?value=13:00&prettyPrint')) {
        print 'Error while connecting: ' . $post->error;
        exit;
    }*/


    //$result = file_get_contents ($url);


}

?>