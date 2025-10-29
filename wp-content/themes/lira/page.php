<?
get_header();
?>

<main>

  <? lira_breadcrumbs(); ?>

  <div class="page-content">
    <div class="page-content__container">
      <h1 class="entry-title"><?= the_title() ?></h1>
      <article id="post" class="post type-post">
        <div class="entry-content">
          <?= the_content() ?>
      </article>
    </div>
  </div>


</main>


<? get_footer(); ?>
