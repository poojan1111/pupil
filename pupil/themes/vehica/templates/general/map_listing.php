<?php
/* @var \Vehica\Widgets\General\MapListingGeneralWidget $vehicaCurrentWidget */
global $vehicaCurrentWidget, $vehicaCarCard, $vehicaSearchField;
$vehicaCarCard = $vehicaCurrentWidget->getCarCard();
$vehicaCars = $vehicaCurrentWidget->getCars();
$vehicaInitialFilters = $vehicaCurrentWidget->getInitialFilters();
$vehicaLocationField = $vehicaCurrentWidget->getLocationField();

if (!$vehicaLocationField) {
    return;
}

$vehicaSearchField = $vehicaLocationField->getSearchField();
$vehicaSearchField->setShowMyLocationButton($vehicaCurrentWidget->showMyLocation());
$vehicaSearchFields = $vehicaCurrentWidget->getSearchFields();

$vehicaLocationField->getViewportPoints();
?>
<div class="vehica-app">
    <vehica-query-cars
            request-url="<?php echo esc_url(admin_url('admin-ajax.php?action=vehica_car_results')); ?>"
            :limit="<?php echo esc_attr($vehicaCurrentWidget->getResultsLimit()); ?>"
            sort-by-rewrite="<?php echo esc_html(vehicaApp('sort_by_rewrite')); ?>"
            keyword-rewrite="<?php echo esc_html(vehicaApp('keyword_rewrite')); ?>"
            initial-sort-by="<?php echo esc_attr($vehicaCurrentWidget->getInitialSortBy()); ?>"
            default-sort-by="<?php echo esc_attr($vehicaCurrentWidget->getDefaultSortBy()); ?>"
            :initial-results-count="<?php echo esc_attr($vehicaCurrentWidget->getCarsCount()); ?>"
            initial-formatted-results-count="<?php echo esc_attr($vehicaCurrentWidget->getFormattedCarsCount()); ?>"
            :initial-terms-count="<?php echo htmlspecialchars(json_encode($vehicaCurrentWidget->getTermsCount())); ?>"
            :initial-filters="<?php echo htmlspecialchars(json_encode($vehicaInitialFilters)); ?>"
            :additional-settings="<?php echo htmlspecialchars(json_encode($vehicaCurrentWidget->getAdditionalSettings())); ?>"
            :card-config="<?php echo htmlspecialchars(json_encode($vehicaCurrentWidget->getCardConfig())) ?>"
            initial-keyword="<?php echo esc_attr($vehicaCurrentWidget->getInitialKeywordValue()); ?>"
            view="<?php echo esc_attr($vehicaCarCard->getType()); ?>"
            :initial-page="<?php echo esc_attr($vehicaCurrentWidget->getInitialPage()); ?>"
            :initial-markers="<?php echo htmlspecialchars(json_encode($vehicaCurrentWidget->getMarkersData($vehicaCars, $vehicaLocationField))); ?>"
            :initial-show-filters="false"
            :map-mode="true"
            :filters-count-keyword="true"
            base-url="<?php echo esc_url($vehicaCurrentWidget->getBaseUrl()); ?>"
        <?php if ($vehicaCurrentWidget->excludeLocationFieldFromFiltersCount($vehicaSearchField, $vehicaSearchFields) === false): ?>
            :exclude-from-filters-count="<?php echo htmlspecialchars(json_encode([$vehicaLocationField->getKey() . '_id'])); ?>"
        <?php endif; ?>
        <?php if ($vehicaCurrentWidget->hasContentField()) : ?>
            marker-content-field-key="<?php echo esc_attr($vehicaCurrentWidget->getContentFieldKey()); ?>"
        <?php endif; ?>
        <?php if ($vehicaCurrentWidget->isCardV5()) : ?>
            content-class="vehica-listing-card-v5-list"
        <?php else : ?>
            content-class="vehica-inventory-v1__results"
        <?php endif; ?>
    >
        <div slot-scope="searchFormProps" <?php $vehicaCurrentWidget->print_render_attribute_string('main') ?>>
            <div
                    class="vehica-inventory-v1 vehica-inventory-v1--map"
                    :class="{'vehica-inventory-v1__is-reloading': searchFormProps.isReloading}"
            >
                <div class="vehica-inventory-v1__map-form">
                    <div
                            class="vehica-inventory-v1__form"
                            :class="{'vehica-inventory-v1__form--active': !searchFormProps.mapView}"
                    >
                        <div class="vehica-inventory-v1__form__fields">

                            <div class="vehica-inventory-v1__location-field-wrapper">
                                <?php get_template_part('templates/search/fields/location'); ?>
                            </div>

                            <div class="vehica-inventory-v1__form__fields__buttons">
                                <?php if (vehicaApp('is_compare_enabled')) : ?>
                                    <vehica-compare>
                                        <div
                                                slot-scope="compare"
                                                class="vehica-inventory-v1__button-option vehica-inventory-v1__button-option--compare"
                                                :class="{'vehica-inventory-v1__button-option--active': compare.compareMode}"
                                                @click.prevent="compare.setCompareMode"
                                        >
                                            <i class="fas fa-exchange-alt"></i>

                                            <?php echo esc_html(vehicaApp('compare_string')) ?>

                                            <template v-if="compare.compareMode">
                                                ({{ compare.cars.length }})
                                            </template>
                                        </div>
                                    </vehica-compare>
                                <?php endif; ?>

                                <div
                                        @click.prevent="searchFormProps.setShowFilters"
                                        class="vehica-inventory-v1__button-option vehica-inventory-v1__button-option--more-filters"
                                >
                                    <?php echo esc_html(vehicaApp('more_filters_string')) ?>
                                    <template v-if="searchFormProps.filtersCount > 0">
                                        ({{ searchFormProps.filtersCount }})
                                    </template>
                                </div>
                            </div>
                        </div>

                        <template v-if="searchFormProps.showFilters">
                            <div class="vehica-inventory-v1__map-more-filters-area">
                                <div class="vehica-results__fields">
                                    <div class="vehica-results__fields__mobile-section-top">
                                        <h3 class="vehica-results__fields__mobile-section-top__title">
                                            <?php echo esc_html(vehicaApp('filters_string')); ?>
                                        </h3>

                                        <h4 class="vehica-results__fields__mobile-section-top__subtitle">
                                            <template>
                                                <span class="vehica-results__fields__mobile-section-top__subtitle__number">
                                                    {{ searchFormProps.resultsCount }}
                                                </span>
                                            </template>

                                            <span class="vehica-results__fields__mobile-section-top__subtitle__label">
                                                <?php echo esc_html(vehicaApp('results_string')); ?>
                                            </span>

                                            <span
                                                    v-if="searchFormProps.filtersCount > 0"
                                                    @click="searchFormProps.reset"
                                                    class="vehica-results__fields__mobile-section-top__subtitle__clear"
                                            >
                                                <?php echo esc_html(vehicaApp('clear_all_string')); ?>
                                            </span>
                                        </h4>

                                        <div
                                                @click.prevent="searchFormProps.setShowFilters"
                                                class="vehica-results__fields__mobile-section-top__close"
                                        >
                                            <i class="fa fa-times-circle"></i>
                                        </div>
                                    </div>

                                    <?php if ($vehicaCurrentWidget->showKeyword()) : ?>
                                        <div
                                                class="vehica-inventory-v1__map-keyword vehica-results__field"
                                                :class="{'vehica-inventory-v1__keyword--active': searchFormProps.keyword.length > 0}"
                                        >
                                            <input
                                                    @input="searchFormProps.setKeyword($event.target.value)"
                                                    :value="searchFormProps.keyword"
                                                    type="text"
                                                    maxlength="25"
                                                    placeholder="<?php echo esc_html(vehicaApp('enter_keyword_string')); ?>"
                                                    value="<?php echo esc_attr($vehicaCurrentWidget->getInitialKeywordValue()); ?>"
                                            >

                                            <div
                                                    v-if="searchFormProps.keyword.length > 0"
                                                    @click="searchFormProps.setKeyword('')"
                                                    class="vehica-inventory-v1__clear-keyword"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     width="10" height="10">
                                                    <path d="M6.895455 5l2.842897-2.842898c.348864-.348863.348864-.914488 0-1.263636L9.106534.261648c-.348864-.348864-.914489-.348864-1.263636 0L5 3.104545 2.157102.261648c-.348863-.348864-.914488-.348864-1.263636 0L.261648.893466c-.348864.348864-.348864.914489 0 1.263636L3.104545 5 .261648 7.842898c-.348864.348863-.348864.914488 0 1.263636l.631818.631818c.348864.348864.914773.348864 1.263636 0L5 6.895455l2.842898 2.842897c.348863.348864.914772.348864 1.263636 0l.631818-.631818c.348864-.348864.348864-.914489 0-1.263636L6.895455 5z"></path>
                                                </svg>
                                            </div>

                                        </div>
                                    <?php endif; ?>

                                    <?php
                                    global $vehicaSearchField;
                                    foreach ($vehicaSearchFields as $vehicaSearchField) :
                                        /* @var \Vehica\Search\Field\SearchField|\Vehica\Search\Field\SearchField $vehicaSearchField */
                                        if ($vehicaSearchField->isTaxonomy()) :
                                            get_template_part('templates/search/fields/taxonomy');
                                        elseif ($vehicaSearchField->isNumberField()) :
                                            get_template_part('templates/search/fields/number');
                                        elseif ($vehicaSearchField->isPriceField()) :
                                            get_template_part('templates/search/fields/price');
                                        elseif ($vehicaSearchField->isTextField()) :
                                            get_template_part('templates/search/fields/text');
                                        elseif ($vehicaSearchField->isDateField()) :
                                            get_template_part('templates/search/fields/date');
                                        elseif ($vehicaSearchField->isLocationField()) :
                                            get_template_part('templates/search/fields/location');
                                        endif;
                                    endforeach;
                                    ?>
                                    <div class="vehica-results__fields__clear-load-more">
                                        <div
                                                class="vehica-results__fields__clear"
                                                @click="searchFormProps.reset"
                                        >
                                            <?php echo esc_html(vehicaApp('clear_all_string')); ?>
                                        </div>
                                    </div>

                                    <div class="vehica-results__fields__mobile-section-bottom">
                                        <button @click.prevent="searchFormProps.setShowFilters" class="vehica-button">
                                            <?php echo esc_html(vehicaApp('apply_string')); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div class="vehica-inventory-v1__bar vehica-inventory-v1__bar--small">
                            <div class="vehica-inventory-v1__bar__left">
                                <?php if ($vehicaCurrentWidget->hasPrimaryFieldTerms()) : ?>
                                    <vehica-taxonomy-search-field
                                            :taxonomy="<?php echo htmlspecialchars(json_encode($vehicaCurrentWidget->getPrimaryFieldTaxonomy())); ?>"
                                            :filters="searchFormProps.filters"
                                            :terms="<?php echo htmlspecialchars(json_encode($vehicaCurrentWidget->getPrimaryFieldTerms())); ?>"
                                            :terms-count="searchFormProps.terms"
                                            :show-always="true"
                                    >
                                        <div
                                                slot-scope="taxonomyField"
                                                class="vehica-search-v1__tabs"
                                                v-dragscroll.pass="true"
                                        >
                                            <div
                                                    class="vehica-search-v1__tab vehica-search-v1__tab--all"
                                                    :class="{'vehica-search-v1__tab--active': taxonomyField.showAll}"
                                            >
                                                <button
                                                        @click.prevent="taxonomyField.clearSelection"
                                                        class="vehica-search-v1__tab-button"
                                                >
                                                    <?php echo esc_html(vehicaApp('all_string')); ?>
                                                    <template>
                                                        <span class="vehica-search-v1__tab-count">
                                                            ({{ taxonomyField.getTermCount(taxonomyField.key) }})
                                                        </span>
                                                    </template>
                                                </button>
                                            </div>

                                            <?php foreach ($vehicaCurrentWidget->getPrimaryFieldTerms() as $vehicaTerm) :
                                                /* @var \Vehica\Model\Term\Term $vehicaTerm */
                                                ?>
                                                <div
                                                        class="vehica-search-v1__tab"
                                                        :class="{'vehica-search-v1__tab--active': taxonomyField.isTermSelected(<?php
                                                        echo esc_attr($vehicaTerm->getId()); ?>)}"
                                                >
                                                    <button
                                                            @click.prevent="taxonomyField.setTermId(<?php echo esc_attr($vehicaTerm->getId()); ?>)"
                                                            :disabled="taxonomyField.isTermDisabled(<?php echo esc_attr($vehicaTerm->getId()); ?>)"
                                                            class="vehica-search-v1__tab-button"
                                                    >
                                                        <?php echo esc_html($vehicaTerm->getName()) ?>
                                                        <template>
                                                            <span class="vehica-search-v1__tab-count">
                                                                ({{
                                                                taxonomyField.getTermCount(<?php echo esc_attr($vehicaTerm->getId()); ?>
                                                                )}})
                                                            </span>
                                                        </template>
                                                    </button>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </vehica-taxonomy-search-field>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="vehica-inventory-v1__middle">
                            <div>
                                <div v-if="false" class="vehica-inventory-v1__title">
                                    <span><?php echo esc_html($vehicaCurrentWidget->getCarsCount()); ?></span>
                                    <?php if ($vehicaCurrentWidget->getCarsCount() === 1) : ?>
                                        <?php echo esc_html(vehicaApp('result_string')); ?>
                                    <?php else : ?>
                                        <?php echo esc_html(vehicaApp('results_string')); ?>
                                    <?php endif; ?>
                                </div>

                                <template>
                                    <div class="vehica-inventory-v1__title">
                                        <template v-if="searchFormProps.resultsCount === 1">
                                            {{ searchFormProps.resultsCount }}
                                            <?php echo esc_html(vehicaApp('result_string')); ?>
                                        </template>

                                        <template v-if="searchFormProps.resultsCount !== 1">
                                            {{ searchFormProps.resultsCount }}
                                            <?php echo esc_html(vehicaApp('results_string')); ?>
                                        </template>
                                    </div>
                                </template>
                            </div>

                            <?php if ($vehicaCurrentWidget->showSortBy()) : ?>
                                <div class="vehica-inventory-v1__sort">
                                    <?php if ($vehicaCurrentWidget->showViewSelector()) : ?>
                                        <div class="vehica-inventory-v1__view">
                                            <button
                                                    @click.prevent="searchFormProps.setView('v2')"
                                                <?php if ($vehicaCurrentWidget->isCardV2()) : ?>
                                                    class="vehica-inventory-v1__view__button-active"
                                                <?php endif; ?>
                                            >

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     width="20" height="20"
                                                     viewBox="0 0 20 20">
                                                    <g
                                                            transform="translate(-819 -493)">
                                                        <rect
                                                                data-name="Rectangle 5"
                                                                width="9" height="8"
                                                                rx="3"
                                                                transform="translate(819 493)"
                                                                fill="#888e95"
                                                        />
                                                        <rect
                                                                data-name="Rectangle 6"
                                                                width="9" height="8"
                                                                rx="3"
                                                                transform="translate(830 493)"
                                                                fill="#888e95"
                                                        />
                                                        <rect
                                                                data-name="Rectangle 7"
                                                                width="9" height="8"
                                                                rx="3"
                                                                transform="translate(830 505)"
                                                                fill="#888e95"
                                                        />
                                                        <rect
                                                                data-name="Rectangle 8"
                                                                width="9" height="8"
                                                                rx="3"
                                                                transform="translate(819 505)"
                                                                fill="#888e95"
                                                        />
                                                    </g>
                                                </svg>
                                            </button>

                                            <button
                                                    @click.prevent="searchFormProps.setView('v5')"
                                                <?php if ($vehicaCurrentWidget->isCardV5()) : ?>
                                                    class="vehica-inventory-v1__view__button-active"
                                                <?php endif; ?>
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     width="25" height="20"
                                                     viewBox="0 0 25 20">
                                                    <g id="lista"
                                                       transform="translate(-830 -493)">
                                                        <rect
                                                                data-name="Rectangle 6"
                                                                width="25" height="8"
                                                                rx="3"
                                                                transform="translate(830 493)"
                                                                fill="#888e95"
                                                        />
                                                        <rect
                                                                data-name="Rectangle 7"
                                                                width="25" height="8"
                                                                rx="3"
                                                                transform="translate(830 505)"
                                                                fill="#888e95"
                                                        />
                                                    </g>
                                                </svg>
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                    <div class="vehica-inventory-v1__sort__heading">
                                        <?php echo esc_html(vehicaApp('sort_by_string')); ?>:
                                    </div>

                                    <div class="vehica-inventory-v1__sort__select">
                                        <div v-if="false" class="vehica-form-button">
                                            <?php echo esc_html($vehicaCurrentWidget->getInitialSortByLabel()); ?>
                                        </div>

                                        <template>
                                            <v-select
                                                    :options="<?php echo htmlspecialchars(json_encode($vehicaCurrentWidget->getSortByOptions())); ?>"
                                                    label="name"
                                                    :append-to-body="false"
                                                    :reduce="option => option.key"
                                                    @input="searchFormProps.setSortBy"
                                                    :clearable="false"
                                                    :value="searchFormProps.sortBy"
                                                    :searchable="false"
                                            >
                                            </v-select>
                                        </template>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="vehica-inventory-v1--map__mobile-modes">
                            <button
                                    v-if="!searchFormProps.mapView"
                                    @click.prevent="searchFormProps.setMapView"
                                    class="vehica-button"
                            >
                                <i class="far fa-map"></i> <?php echo esc_html(vehicaApp('map_view_string')); ?>
                            </button>
                        </div>

                        <div>
                            <?php if ($vehicaCurrentWidget->isCardV5()) : ?>
                                <div class="vehica-listing-card-v5-list">
                                    <?php foreach ($vehicaCars as $vehicaCurrentCar) : ?>
                                        <?php $vehicaCarCard->loadTemplate($vehicaCurrentCar); ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php else : ?>
                                <div class="vehica-inventory-v1__results">
                                    <?php foreach ($vehicaCurrentWidget->getCars() as $vehicaCurrentCar) : ?>
                                        <div class="vehica-inventory-v1__results__card">
                                            <?php $vehicaCarCard->loadTemplate($vehicaCurrentCar); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <template>
                            <div class="vehica-inventory-v1__pagination vehica-pagination-mobile--inventory">
                                <vehica-pagination
                                        :total-items="searchFormProps.resultsCount"
                                        :current-page="searchFormProps.currentPage"
                                        :page-size="searchFormProps.limit"
                                        :max-pages="7"
                                >
                                    <div
                                            slot-scope="pagination"
                                            v-if="pagination.pages.length > 1"
                                    >
                                        <div class="vehica-pagination-mobile">
                                            <button
                                                    @click.prevent="searchFormProps.setPrevPage"
                                                    class="vehica-pagination-mobile__arrow vehica-pagination-mobile__arrow--left"
                                                    :class="{'vehica-pagination-mobile__arrow--disabled': pagination.currentPage === 1}"
                                                    :disabled="pagination.currentPage === 1"
                                            >
                                                <i class="fa fa-chevron-left"></i>
                                            </button>

                                            <span class="vehica-pagination-mobile__start">{{ pagination.currentPage
                                                }}</span>

                                            <span class="vehica-pagination-mobile__middle">/</span>

                                            <span class="vehica-pagination-mobile__end">{{ pagination.totalPages
                                                }}</span>

                                            <button
                                                    @click.prevent="searchFormProps.setNextPage"
                                                    class="vehica-pagination-mobile__arrow vehica-pagination-mobile__arrow--right"
                                                    :class="{'vehica-pagination-mobile__arrow--disabled': pagination.currentPage === pagination.endPage}"
                                                    :disabled="pagination.currentPage === pagination.endPage"
                                            >
                                                <i class="fa fa-chevron-right"></i>
                                            </button>
                                        </div>

                                        <div class="vehica-pagination vehica-pagination--inventory">
                                            <div class="vehica-pagination__inner">
                                                <div
                                                        v-if="pagination.currentPage > 1"
                                                        class="vehica-pagination__arrow vehica-pagination__arrow--left"
                                                        @click.prevent="searchFormProps.setPrevPage"
                                                >
                                                    <i class="fa fa-chevron-left"></i>
                                                </div>

                                                <div
                                                        v-if="pagination.startPage > 1"
                                                        class="vehica-pagination__page"
                                                        @click.prevent="searchFormProps.setCurrentPage(1)"
                                                >
                                                    1
                                                </div>

                                                <div v-if="pagination.startPage > 2" class="vehica-pagination__page">
                                                    ...
                                                </div>

                                                <div
                                                        v-for="page in pagination.pages"
                                                        class="vehica-pagination__page"
                                                        :class="{'vehica-pagination__page--active': page === searchFormProps.currentPage}"
                                                        @click.prevent="searchFormProps.setCurrentPage(page)"
                                                >
                                                    {{ page }}
                                                </div>

                                                <div
                                                        v-if="pagination.currentPage < pagination.endPage"
                                                        class="vehica-pagination__arrow vehica-pagination__arrow--right"
                                                        @click.prevent="searchFormProps.setNextPage"
                                                >
                                                    <i class="fa fa-chevron-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </vehica-pagination>
                            </div>
                        </template>
                    </div>

                    <div
                        <?php if (!empty(vehicaApp('google_maps_api_key'))) : ?>
                            class="vehica-inventory-v1__map"
                        <?php else : ?>
                            class="vehica-inventory-v1__map vehica-inventory-v1__map--no-api-key"
                        <?php endif; ?>
                            :class="{'vehica-inventory-v1__map--active': searchFormProps.mapView}"
                    >
                        <div class="vehica-inventory-v1__map__inner">

                            <template>
                                <div class="vehica-inventory-v1__map__switch-map-to-lists">
                                    <button
                                            v-if="searchFormProps.mapView"
                                            @click.prevent="searchFormProps.setMapView"
                                            class="vehica-button vehica-button--switch-map-to-lists"
                                    >
                                        <i class="fas fa-th-large"></i> <?php echo esc_html(vehicaApp('list_view_string')); ?>
                                    </button>
                                </div>
                            </template>

                            <?php if (empty(vehicaApp('google_maps_api_key'))) : ?>
                                <div class="vehica-map__no-api-key">
                                    <div class="vehica-map__no-api-key__inner">
                                        <div class="vehica-map__no-api-key__icon">
                                            <i class="fas fa-map-marked-alt"></i>
                                        </div>
                                        <h3><?php esc_html_e('You must add Google Maps API Key to display map', 'vehica'); ?></h3>
                                        <p><?php esc_html_e('You can do it in the /wp-admin/ > Vehica Panel > Google Maps', 'vehica'); ?></p>
                                    </div>
                                </div>
                            <?php else : ?>
                                <vehica-map-listing
                                        :filters="searchFormProps.filters"
                                        :location-field="<?php echo htmlspecialchars(json_encode($vehicaLocationField)); ?>"
                                        :markers="searchFormProps.markers"
                                        primary-color="<?php echo esc_attr(vehicaApp('primary_color')); ?>"
                                        :map-view="searchFormProps.mapView"
                                        :initial-viewport-points="<?php echo htmlspecialchars(json_encode($vehicaLocationField->getViewportPoints())); ?>"
                                        :initial-zoom="12"
                                    <?php if ($vehicaCurrentWidget->hasContentField()) : ?>
                                        :content-marker="true"
                                    <?php endif; ?>
                                >
                                    <div slot-scope="mapListing" class="vehica-inventory-v1__map-wrapper">
                                        <div class="vehica-map__search-as-i-move-wrapper">
                                            <div class="vehica-map__search-as-i-move">
                                                <div class="vehica-map__search-as-i-move__loader">
                                                    <svg
                                                            width="120"
                                                            height="30"
                                                            wviewBox="0 0 120 30"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="var(--primary)"
                                                    >
                                                        <circle cx="15" cy="15" r="15">
                                                            <animate attributeName="r" from="15" to="15"
                                                                     begin="0s" dur="0.8s"
                                                                     values="15;9;15" calcMode="linear"
                                                                     repeatCount="indefinite"/>
                                                            <animate attributeName="fill-opacity" from="1" to="1"
                                                                     begin="0s" dur="0.8s"
                                                                     values="1;.5;1" calcMode="linear"
                                                                     repeatCount="indefinite"/>
                                                        </circle>
                                                        <circle cx="60" cy="15" r="9" fill-opacity="0.3">
                                                            <animate attributeName="r" from="9" to="9"
                                                                     begin="0s" dur="0.8s"
                                                                     values="9;15;9" calcMode="linear"
                                                                     repeatCount="indefinite"/>
                                                            <animate attributeName="fill-opacity" from="0.5" to="0.5"
                                                                     begin="0s" dur="0.8s"
                                                                     values=".5;1;.5" calcMode="linear"
                                                                     repeatCount="indefinite"/>
                                                        </circle>
                                                        <circle cx="105" cy="15" r="15">
                                                            <animate attributeName="r" from="15" to="15"
                                                                     begin="0s" dur="0.8s"
                                                                     values="15;9;15" calcMode="linear"
                                                                     repeatCount="indefinite"/>
                                                            <animate attributeName="fill-opacity" from="1" to="1"
                                                                     begin="0s" dur="0.8s"
                                                                     values="1;.5;1" calcMode="linear"
                                                                     repeatCount="indefinite"/>
                                                        </circle>
                                                    </svg>
                                                </div>

                                                <div class="vehica-checkbox">
                                                    <input
                                                            type="checkbox"
                                                            @change="mapListing.setMapSearch"
                                                            :checked="mapListing.mapSearch"
                                                            id="vehica_map_move_map"
                                                    >
                                                    <label for="vehica_map_move_map"><?php echo esc_html(vehicaApp('search_as_i_move_the_map_string')); ?></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                                class="vehica-map-listing"
                                                style="width:100%;height:100%;position: relative;"
                                        ></div>
                                    </div>
                                </vehica-map-listing>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </vehica-query-cars>
</div>
