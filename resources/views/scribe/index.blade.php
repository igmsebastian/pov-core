<!-- See https://github.com/stoplightio/elements/blob/main/docs/getting-started/elements/elements-options.md for config -->
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>POV API Documentation</title>
    <!-- Embed elements Elements via Web Component -->
    <script src="https://unpkg.com/@stoplight/elements/web-components.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/@stoplight/elements/styles.min.css">
    <style>
        body {
            height: 100vh;
        }
    </style>
</head>
<body>

<elements-api
    apiDescriptionUrl="{{ route("scribe.openapi") }}"
    router="hash"
    layout="sidebar"
    hideTryIt=""
    logo="img/logo_black.svg"
/>

</body>
</html>
