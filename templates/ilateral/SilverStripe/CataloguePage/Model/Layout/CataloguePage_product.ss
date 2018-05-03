<% with $Product %>
    <div class="catalogue-content-container container catalogue-product typography">
        <article>
            <h1>$Title</h1>
        </article>
        <div class="content" role="main">
            <div class="units-row row line">
                <div class="unit-50 unit size1of2 col-xs-12 col-sm-6 catalogue-product-images">
                    <div id="catalogue-product-image">
                        <div class="product-image">
                            <a href="{$PrimaryImage.Fit(900,550).URL}">
                                <img class="img-fluid" src="$PrimaryImage.Pad(750,750).URL" alt="$PrimaryImage.Title" title="$PrimaryImage.Title">
                                <% if $Status && $Status != 'On Sale' %>
                                    <span class="status-holder">
                                        <span class="status bg-secondary">
                                            <span class="lead text-white text-uppercase">
                                                <span class="text">$Status</span>
                                            </span>
                                        </span>
                                    </span>
                                <% end_if %>
                            </a>
                        </div>
                        <p class="text-center">
                            <strong>$ProductImage.Title</strong>
                        </p>
                    </div>

                    <div class="units-row-end">
                        <% if $Images.exists %>
                            <div class="thumbs row">
                                <% loop $SortedImages %>
                                    <div class="col-auto">
                                        <a class="d-block" href="$URL">
                                            <img class="img-fluid" src="$Pad(75,75).URL" alt="{$Title}" title="{$Title}">
                                        </a>
                                    </div>
                                <% end_loop %>
                            </div>
                        <% end_if %>
                    </div>
                </div>
                <div class="unit-50 unit size1of2 col-xs-12 col-sm-6 catalogue-product-summary">
                    <% if $ClassName != 'LettingProperty' %>
                        <% if not $HidePrice %>
                            <p class="lead text-success">
                                <span class="price-title">
                                    <% if $OfferPrice %>
                                        Offers in the region of:&nbsp;
                                    <% else %>
                                        Guide Price:&nbsp;
                                    <% end_if %>
                                </span>
                                <strong class="price">
                                    <span class="value">
                                        <% if $IncludesTax %>
                                            {$PriceAndTax.nice}
                                        <% else %>
                                            {$Price.nice}
                                        <% end_if %>
                                    </span>
                                </strong>
                                <span class="price-text"> $PriceText</span>
                            </p>
                            <% if $Lots %>
                                <p class="lead">
                                    <% loop $Lots.Sort('Sort') %>
                                        $Title: $Price.Nice
                                        <% if $Status == 'Sold' %> (SOLD)<% end_if %>
                                        <br />
                                    <% end_loop %>
                                </p>
                            <% end_if %>
                        <% else_if $PriceText %>
                            <p class="lead text-success">
                                <span class="price-text">$PriceText</span>
                            </p>
                        <% end_if %>
                    <% end_if %>
                    <p>$Content</p>
                    <% if $ClassName == 'Property' && $Attachments %>
                        <div class="btn-group btn-group-sm d-sm-flex align-items-center flex-wrap flex-md-nowrap" role="group">
                            <% loop $Attachments %>
                                <% if $Type == 'File' %>
                                    <a class="btn btn-primary w-100" href="$File.Link" rel="nofollow" target="_blank">$Label</a>
                                <% else_if $Type == 'Video'%>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#Video_{$ID}">
                                        $Label
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="Video_{$ID}" tabindex="-1" role="dialog" aria-labelledby="Video_{$ID}_Title" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Property Video</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    $Video.Embed
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <% else_if $Type == 'Link' %>
                                    <a class="btn btn-primary w-100" href="$Link" rel="nofollow" target="_blank">$Label</a>
                                <% end_if %>
                            <% end_loop %>
                        </div>
                    <% end_if %>
                </div>
            </div>
        </div>
    </div>
<% end_with %>
