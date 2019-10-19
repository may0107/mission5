<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Mission5</title>
  </head>
  	<body>
		<?php
			$dsn = '*******';
			$user = '*******';
			$password = '******';
			$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
			//テーブル作成(テーブル名:mission5)
			$sql="CREATE TABLE IF NOT EXISTS mission5"
			."("
			."id INT AUTO_INCREMENT PRIMARY KEY,"
			."name char(32),"
			."comment TEXT,"
			."date TEXT,"
			."pass TEXT"
			.");";
			$stmt=$pdo->query($sql);

			if(isset($_POST["submit2"])){ 
			//削除するとき
				if(!empty($_POST["num1"]) && !empty($_POST["pass2"])){
					$id=$_POST["num1"];
					$sql='SELECT * FROM mission5';
					$stmt=$pdo->query($sql);
					$results=$stmt->fetchAll();
					foreach($results as $word){
						if($word['id']==$id){
							if ($word['pass']==$_POST["pass2"]){
								$sql='delete from mission5 where id=:id';
								$stmt=$pdo->prepare($sql);
								$stmt->bindParam(':id', $id, PDO::PARAM_INT);
								$stmt->execute();

							}else if($word['pass']!=$_POST["pass2"]){
								echo "パスワードが違います";
							}
						}
					}
				}else if(empty($_POST["num1"])){
					echo "番号を入力してください";
				}else if(empty($_POST["pass2"])){
					echo "パスワードを入力してください";
				}
			}

 			if(isset($_POST["submit3"])){
 				//編集したいとき
 				if(!empty($_POST["num2"]) && !empty($_POST["pass3"])){
 					$id=$_POST["num2"];
 					$sql='SELECT * FROM mission5';
					$stmt=$pdo->query($sql);
					$results=$stmt->fetchAll();
					foreach($results as $word_1){
						if($word_1['id']==$id){
							if ($word_1['pass']==$_POST["pass3"]){
								foreach($results as $word_2){
									if($word_2['id']==$id){
										$get_num=$word_2['id'];
										$get_name=$word_2['name'];
										$get_comment=$word_2['comment'];
									}
								}
								$stmt->execute();
							}else if($word_1['pass']!=$_POST["pass3"]){
								echo "パスワードが違います";
							}
						}
					}
				}else if(empty($_POST["num2"])){
					echo "番号を入力してください";
				}else if(empty($_POST["pass3"])){
					echo "パスワードを入力してください";
				}
			}

			if(isset($_POST["submit1"])){
				if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass1"])){
					//ただ書き込むとき
					if(empty($_POST["num3"])){
						$sql=$pdo->prepare("INSERT INTO mission5 (name,comment,date,pass) VALUES (:name, :comment, :date, :pass)");
						$sql->bindParam(':name', $name, PDO::PARAM_STR);
						$sql->bindParam(':comment', $comment, PDO::PARAM_STR);
						$sql->bindParam(':date', $date, PDO::PARAM_STR);
						$sql->bindParam(':pass', $pass, PDO::PARAM_STR);

						$name=$_POST["name"];//名前
						$comment=$_POST["comment"];//コメント
						$date=date("Y/m/d H:i:s");//投稿時間
						$pass=$_POST["pass1"];//パスワード

						$sql->execute();
					}else if(!empty($_POST["num3"])){
						//編集のために書き換えるとき
						$id=$_POST["num3"];
						$name=$_POST["name"];
						$comment=$_POST["comment"];
						$date=date("Y/m/d H:i:s");
						$pass=$_POST["pass1"];
						$sql='update mission5 set name=:name,comment=:comment, date=:date, pass=:pass where id=:id';
						$stmt=$pdo->prepare($sql);
						$stmt->bindParam(':name', $name, PDO::PARAM_STR);
						$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
						$stmt->bindParam(':date', $date, PDO::PARAM_STR);
						$stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
						$stmt->bindParam(':id', $id, PDO::PARAM_INT);
						$stmt->execute();
					}
				}else if(empty($_POST["name"])){
					echo "名前を入力してください";
				}else if(empty($_POST["comment"])){
				  echo "コメントを入力してください";
				}else if(empty($_POST["pass1"])){
				echo "パスワードを入力してください";
				}
			}

		?>

		<form action="<?php print($_SERVER['PHP_SELF']) ?>" method="post">
			<input type="hidden" name="num3"
							value="<?php
										if(isset($_POST['submit3']) && !empty($get_num)){
											print $get_num;
										}
										?>"
							>
			<br>
			名前：<br />
			<input type="text" name="name"
						value="<?php
									if(isset($_POST['submit3']) && !empty($get_name)){
										print $get_name;
                     				}
                     				?>"
            			placeholder="名前"><br>
            コメント：<br />
			<input type="text" name="comment"
							value="<?php
										if(isset($_POST['submit3']) && !empty($get_comment)){
                                                print $get_comment;
                                    	}
                                     	?>"
							placeholder="コメント"><br>
			 Password：<br />
			<input type="password" name="pass1" placeholder="パスワード">
			<input type="submit" name="submit1" value="送信">
			<br><br>
			 削除：<br />
			<input type="text" name="num1" placeholder="削除番号"><br>
			Password：<br />
			<input type="password" name="pass2" placeholder="パスワード">
			<input type="submit" name="submit2" value="削除">
			<br><br>
			編集：<br />
			<input type="text" name="num2" placeholder="編集番号"><br>
			Password：<br />
			<input type="password" name="pass3" placeholder="パスワード">
			<input type="submit" name="submit3" value="編集">

		</form>

		<?php
			//ブラウザ表示
			if(isset($_POST["submit1"])||isset($_POST["submit2"])||isset($_POST["submit3"])){
				$dsn = '*******';
				$user = '*******';
				$password = '******';
				$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

				$sql='SELECT * FROM mission5';
				$stmt=$pdo->query($sql);
				$results=$stmt->fetchAll();
				foreach ($results as $row){
					echo $row['id'].',';
					echo $row['name'].',';
					echo $row['comment'].',';
					echo $row['date'].'<br>';
					echo "<hr>";
				}
			}
		?>

	</body>
</html>
