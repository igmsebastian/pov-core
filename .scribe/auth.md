# Authenticating Requests

To authenticate requests, include an **`Authorization`** header with the value **`"Bearer {YOUR_ACCESS_TOKEN}"`**.

All protected endpoints are marked with a `requires authentication` badge in the documentation below.

Authenticated user data is retrieved via an **LDAP connection**.

To obtain your access token, send a `POST` request to the **`/api/auth/login`** endpoint with your LDAP credentials.

Once authenticated, you will receive an access token to include in your API requests.