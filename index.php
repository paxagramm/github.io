<?php 
	require "includes/config.php";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title><?php echo $config['title']; ?></title>
	<link href="includes/style.css" rel="stylesheet" type="text/css">
</head>
<body>
	
	<?php include "includes/header.php"; ?>

			<!-- Center -->
	<div class="block">
		
		<h3>Новейшее в блогах</h3>
		 
		 <?php 
			$per_page = 1;
			$page = 1;
			
			if(isset($_GET['page']))
			{
				$page = (int) $_GET['page'];
			}
			$total_count_q = mysqli_query($connection, 'SELECT COUNT(id) AS total_count FROM articles');
			$total_count = mysqli_fetch_assoc($total_count_q);
			$total_count = $total_count['total_count'];
			
			$total_pages = ceil($total_count / $per_page);
			if($page <= 1 || $page > $total_pages)
			{
				$page = 1;
			}
			$offset = 0;
			
			$offset = ($per_page * $page) - $per_page;
			
			$articles = mysqli_query($connection, "SELECT * FROM articles ORDER BY id DESC LIMIT  $offset, $per_page ");
			
			$articles_exist = true;
			if(mysqli_num_rows($articles)<=0)
			{
				echo 'Статей не существует!';
				$article_exist = false;
			}
		?>
			<?php
			while( $art = mysqli_fetch_assoc($articles) )
			{
		?>
				<article class="article">
					<div class="article_image" style="background-image: url(/media/images/<?php echo $art['image']; ?>);"></div>
					<div class="article_info">
						<a href="/article.php?id=<?php echo $art['id'];?>"><?php echo $art['title'];?></a>
					<div class="article_info_meta">
					<?php 
						$art_cat = false;
						foreach($categories as $cat)
						{
							if($cat['id'] == $art_cat['categorie_id'])
							{
								$art_cat = $cat;
								break;
							}
						}
					?>
						<small><a href="../article.php?categorie=<?php echo $art_cat['id'];?>"><?php echo $art_cat['title'];?></a></small>
					</div>
					<div class="article_info_preview"><?php echo mb_substr(strip_tags($art['text']),0,100, 'utf-8') . ' ...'; ?></div>
					</div>
				</article>
				<?php
			}
					if ( $articles_exist == true)
			{
				echo '<div class="plaginator">';
					if ($page > 1)
					{
						echo'<a href="/index.php?page='.($page - 1).'">Прошлая страница</a>';
					}
					if($page < $total_pages)
					{
						echo'<a href="/index.php?page='.($page + 1).'">Следуйщая страница</a>';
					}
				echo '</div>';
			}
				
	require "includes/config.php";
?>
	</div>
	
		<?php include "includes/footer.php"; ?>
</body>
</html>