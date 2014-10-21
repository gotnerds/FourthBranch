
<aside id="newsOfTheDay" class="newsPage">
    <h4>News of the Day</h4>
    <?php
        $sql = 'SELECT   *, GROUP_CONCAT(category ORDER BY id ASC) grouped_cat FROM news GROUP BY id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        if ( $stmt->rowCount() >= 1) {
            $newsItems = $stmt->rowCount();
            while ($row = $stmt->fetchAll()){
                $count = 1;
                $newList = sortList($row);
                foreach ($newList as $key => $value) {
                    if ($count < 7) {
                        //category
                        echo '<picture class="notdLinks">';
                        echo '<p>'.$key.'</p>';
                        echo '<div class="newsItem" style="height:auto;" headline="'.$value[0]['title'].'" headliners="'.$value[0]['title'];
                        foreach ($value as $k => $v) {
                            if ($k == "0"){

                            }else{
                            echo '/'.$v['title'];
                            }
                        }
                        echo '"><a class="linkerrr" href="'.$value[0]["news_url"].'" target="_blank" data-alturl="'.$value[0]["news_url"];
                        foreach ($value as $k => $v) {
                            if ($k == "0"){

                            }else{
                            echo ','.$v['news_url'];
                            }
                        }
                        echo'"><img class="newsImage" src="'.$value[0]['photo'].'" data-altsrc="'.$value[0]['photo'];
                        foreach ($value as $k => $v) {
                            if ($k == "0"){

                            }else{
                            echo ','.$v['photo'];
                            }
                        }
                        echo '" align="center">
                                </a>';
                        echo '</div>';
                        $count++;
                        echo '</picture>';
                    }
                }
                     
            }
        } else {
            echo "<h4> Sorry there is no news today </h4>";
        }
    ?>
</aside>
<!--     <picture class="notdLinks">
        <p>Politics</p>
        <img src="./images/notd1.jpg" alt="Politics">
    </picture>
    <picture class="notdLinks">
        <p>Business</p>
        <img src="./images/notd2.jpg" alt="Business">
    </picture>
    <picture class="notdLinks">
        <p>World</p>
        <img src="./images/notd3.jpg" alt="World">
    </picture>
    <picture class="notdLinks">
        <p>News as Usual</p>
        <img src="./images/notd4.jpg" alt="News as Usual">
    </picture>
</aside>
 -->