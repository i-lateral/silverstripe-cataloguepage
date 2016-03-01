<% include SideBar %>

<div class="content-container <% if $Menu(2) %>unit-75<% end_if %>">

    <article>
        <h1>$Title</h1>
        <div class="content">
            $Content
        </div>
    </article>

    <div class="units-row line cataloguepage-products">
        <% if $Categories.exists %>
            <% loop $Children %>
                <h2>$Title</h2>

                <hr />

                <% if $SortedProducts.exists %>
                    <div class="units-row line cataloguepage-products">
                        <% loop $SortedProducts %>
                            <% include CataloguePageProduct %>

                            <% if $MultipleOf(2) && not $Last %>
                                </div><div class="units-row line cataloguepage-products">
                            <% end_if %>
                        <% end_loop %>
                    </div>
                <% end_if %>
            <% end_loop %>
        <% else %>
            <% loop $Children %>
                <% include CataloguePageProduct %>

                <% if $MultipleOf(2) && not $Last %>
                    </div><div class="units-row line cataloguepage-products">
                <% end_if %>
            <% end_loop %>
        <% end_if %>
    </div>
</div>
