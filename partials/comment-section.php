<section class="comment-section">
    <h2>Webmentions</h2>

    <div id="webmentions"></div>
    
    <form action="https://webmention.io/geheimesite.nl/webmention" method="post">
        <p>This post accepts <a href="https://webmention.net">webmentions</a>. Let me know the URL of your <a href="https://indieweb.org/responses">response</a>:</p>

        <input type="url" name="source">
        <input type="hidden" name="target" value="<?= $post->uri ?>">
        <input type="submit" class="ui submit button" value="Send Webmention">
    </form>
</section>