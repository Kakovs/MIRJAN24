<div id="editor">
    <h2>Content:</h2>
    <div class="content">
        {if isset($taskContent) && !empty($taskContent)}
            {$taskContent nofilter}
        {else}
            <p>No content available.</p>
        {/if}
    </div>
</div>