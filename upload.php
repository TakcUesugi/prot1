<!DOCTYPE html>
        <html lang="ja">
            <head>
                <meta charset="UTF-8">
                <title>misson_5-1.php</title>
            </head>
            <body>
            <h1>あなたが最近ハマっている食べ物</h1>
                <form action="" method="post">
                    <入力フォーム><br>
        
                    <input type="text" name="name" 
                    placeholder="名前" value=><br>
                    <input type="text" name="comment" 
                    placeholder="食べ物" value=><br>
                    <input type="password" name="pass" placeholder="パスワード" value=><br>
                    <input type="number" name="ENO" placeholder=編集対象番号 value=><br>
                    <input type="submit" name="submit" ><br>
                    ＊編集したい場合は編集対象番号欄に編集したい投稿番号を入力し、名前・食べ物を再度入力して送信ボタンを押してください
                    <br><br>
        
                    <削除フォーム><br>
                    <input type="number" name="delete" 
                    placeholder="削除対象番号"> <br>
                    <input type="password" name="delPas" placeholder="パスワード" >
                    <input type="submit" value="削除"><br>
                    
                </form>


<?php
        // DB接続設定
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

        //CREATE文：データベース内にテーブルを作成	
        //表の中の項目（カラム）を設定
	    $sql = "CREATE TABLE IF NOT EXISTS tbt5_1"
	    ." ("
	    . "id INT AUTO_INCREMENT PRIMARY KEY,"
	    . "name char(32),"
	    . "comment TEXT,"
        . "dt datetime,"
        . "pass varchar(32)"
	    .");";
	    $stmt = $pdo->query($sql);

        //変数定義
        $filename="mission_5-1.txt";
        $comment = $_POST["comment"];
        $name = $_POST["name"];
        $date = date("Y/m/d H:i:s");

        $Pas=$_POST["pass"];
        $delPas=$_POST["delPas"];
        $delete=$_POST["delete"];

        $ENO=$_POST["ENO"];




        //編集機能
        //編集番号欄とパスワード欄が空欄でないとき
        if(!empty($ENO)){
            
            $sql = 'UPDATE tbt5_1 SET name=:name,comment=:comment WHERE id=:id and pass=:pass';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name2, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment2, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':pass', $Pas2, PDO::PARAM_STR);
            $name2=$name;
            $comment2=$comment;
            $id=$ENO;
            $Pas2=$Pas;            
            $stmt->execute();
        }else{
        //新規投稿
              if(!empty($name) && !empty($comment) &&!empty($Pas)){
                //INSERT文：データを入力（データレコードの挿入）
                $sql = $pdo -> prepare("INSERT INTO tbt5_1 (name, comment,dt,pass) VALUES (:name, :comment,:dt,:pass)");
                $sql->bindParam(':name', $name1, PDO::PARAM_STR);
                $sql->bindParam(':comment', $comment1, PDO::PARAM_STR);
                $sql->bindParam(':dt', $date1, PDO::PARAM_STR);
                $sql->bindParam(':pass', $Pas1, PDO::PARAM_STR);
                $name1=$name;
                $comment1=$comment;
                $date1=$date;
                $Pas1=$Pas;
                $sql -> execute();
              }
            }

        //削除機能
        if(!empty($delete) && !empty($delPas)){
        //DELETE文：入力したデータレコードを削除	
	    //IDとパスワードが一致するデータを抽出　idは表の中のID　;idは消したいID　whereは探す
	        $sql = 'delete from tbt5_1 where id=:id and pass=:pass' ;
	        $stmt = $pdo->prepare($sql);
        //番号を探し出す指示(始めて実行):idの定義づけに近いイメージ
	        $stmt->bindParam(':id', $delete1, PDO::PARAM_INT);
            $stmt->bindParam(':pass', $delPas1, PDO::PARAM_STR);
            $delete1=$delete;
            $delPas1=$delPas;
            $stmt->execute();
        }


    


        //SELECT文：入力したデータレコードを抽出し、表示する
        //抽出のための変数定義
        $sql = 'SELECT * FROM tbt5_1';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        //ブラウザに表示
        foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].',';
                echo $row['dt'].'<br>';
                echo "<hr>";
        }
        
                
                ?>
                
            </body>
        </html>