#--------------------------------------------------------------------
# Example Environment Configuration file
#
# This file can be used as a starting point for your own
# custom .env files, and contains most of the possible settings
# available in a default install.
#
# By default, all of the settings are commented out. If you want
# to override the setting, you must un-comment it by removing the '#'
# at the beginning of the line.
#--------------------------------------------------------------------

#--------------------------------------------------------------------
# ENVIRONMENT
#--------------------------------------------------------------------

CI_ENVIRONMENT = development

# Server Config
app_host = http://localhost:8030
app_env = development

#--------------------------------------------------------------------
# APP
#--------------------------------------------------------------------

$baseURL = 'http://localhost:8030/';
app.baseURL = 'http://localhost:8030/' # <- Disesuaikan dengan port localhost masing-masing
app.forceGlobalSecureRequests = false
app.CSPEnabled = false

#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------

database.default.hostname = localhost
database.default.database = track_my_pack
database.default.username = root
database.default.password = admin
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306

# database.tests.hostname = localhost
# database.tests.database = ci4_test
# database.tests.username = root
# database.tests.password = root
# database.tests.DBDriver = MySQLi
# database.tests.DBPrefix =
# database.tests.port = 3306

#--------------------------------------------------------------------
# CONTENT SECURITY POLICY
#--------------------------------------------------------------------

# contentsecuritypolicy.reportOnly = false
# contentsecuritypolicy.defaultSrc = 'none'
# contentsecuritypolicy.scriptSrc = 'self'
# contentsecuritypolicy.styleSrc = 'self'
# contentsecuritypolicy.imageSrc = 'self'
# contentsecuritypolicy.baseURI = null
# contentsecuritypolicy.childSrc = null
# contentsecuritypolicy.connectSrc = 'self'
# contentsecuritypolicy.fontSrc = null
# contentsecuritypolicy.formAction = null
# contentsecuritypolicy.frameAncestors = null
# contentsecuritypolicy.frameSrc = null
# contentsecuritypolicy.mediaSrc = null
# contentsecuritypolicy.objectSrc = null
# contentsecuritypolicy.pluginTypes = null
# contentsecuritypolicy.reportURI = null
# contentsecuritypolicy.sandbox = false
# contentsecuritypolicy.upgradeInsecureRequests = false
# contentsecuritypolicy.styleNonceTag = '{csp-style-nonce}'
# contentsecuritypolicy.scriptNonceTag = '{csp-script-nonce}'
# contentsecuritypolicy.autoNonce = true

#--------------------------------------------------------------------
# COOKIE
#--------------------------------------------------------------------

cookie.prefix = ''
cookie.expires = 0
cookie.path = '/'
cookie.domain = ''
cookie.secure = false
cookie.httponly = false
cookie.samesite = 'Lax'
cookie.raw = false

#--------------------------------------------------------------------
# ENCRYPTION
#--------------------------------------------------------------------

encryption.key =
encryption.driver = OpenSSL
encryption.blockSize = 16
encryption.digest = SHA512

#--------------------------------------------------------------------
# HONEYPOT
#--------------------------------------------------------------------

honeypot.hidden = 'true'
honeypot.label = 'Fill This Field'
honeypot.name = 'honeypot'
honeypot.template = '<label>{label}</label><input type="text" name="{name}" value=""/>'
honeypot.container = '<div style="display:none">{template}</div>'

#--------------------------------------------------------------------
# SECURITY
#--------------------------------------------------------------------

security.csrfProtection = 'cookie'
# security.tokenRandomize = false
security.tokenName = 'csrf_token_name'
security.headerName = 'X-CSRF-TOKEN'
security.cookieName = 'csrf_cookie_name'
security.expires = 7200
security.regenerate = true
security.redirect = true
security.samesite = 'Lax'
secretkey = kkpkelompok5

#--------------------------------------------------------------------
# SESSION
#--------------------------------------------------------------------

session.driver = 'CodeIgniter\Session\Handlers\FileHandler'
session.cookieName = 'ci_session'
session.expiration = 7200
session.savePath = writable/session
session.matchIP = false
session.timeToUpdate = 300
session.regenerateDestroy = false

#--------------------------------------------------------------------
# LOGGER
#--------------------------------------------------------------------

logger.threshold = 4

#--------------------------------------------------------------------
# CURLRequest
#--------------------------------------------------------------------

curlrequest.shareOptions = true