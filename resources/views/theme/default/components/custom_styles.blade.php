<style type="text/css">

:root {
  --primary-color: {{ get_option('theme_color','#E91E63') }};
}

.header.shop .header-inner {
    background: {{ get_option('navigation_color','#1d2224') }};
}

{!! xss_clean(get_option('custom_css')) !!}

</style>