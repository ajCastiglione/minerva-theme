<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> role="article">

    <header class="article-header entry-header">

        <h1 class="entry-title"><a href="<?= the_permalink() ?>"><?php the_title(); ?></a></h1>

        <p class="byline entry-meta vcard">

            <?php printf(
                __('Posted', 'bonestheme') . ' %1$s %2$s',
                /* the time the post was published */
                '<time class="updated entry-time" datetime="' . get_the_time('Y-m-d') . '" itemprop="datePublished">' . get_the_time(get_option('date_format')) . '</time>',
                /* the author of the post */
                '<span class="by">' . __('by', 'bonestheme') . '</span> <span class="entry-author author" itemprop="author" itemscope itemptype="http://schema.org/Person">' . get_the_author_link(get_the_author_meta('ID')) . '</span>'
            ); ?>

        </p>

    </header>

    <section class="entry-content " itemprop="articleBody">
        <?= the_excerpt(); ?>
    </section>

</article>