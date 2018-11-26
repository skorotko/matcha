<b><h2>Web Matcha project</h2></b>

Authorized languages:<br>
◦ [<b>Server</b>] PHP<br>
◦ [<b>Client</b>]  HTML - CSS - JavaScript<br><br>

Authorized frameworks:<br>
◦ [<b>Server</b>] None<br>
◦ [<b>Client</b>] Vue.js<br>


<b>Web App with the following features:</b><br>
<ul><b>Registration and Signing-in:</b><br>
<li>The app allow a user to register asking at least an email address, a username, a last
name, a first name and a protected password.</li>
<li>After the registration, an
e-mail with an unique link will be sent to the registered user to verify his account.</li>
<li>The user is able to connect with his/her username and password. </li>
<li>He/She is able to receive an email allowing him/her to re-initialize his/her password.</li>
</ul>

<ul><b>Browsing:</b><br>
<li>I propose only “interesting” profiles for example, only men for a heterosexual
girls. I manage bisexuality. If the orientation isn’t specified, the user will
be considered bi-sexual.</li>
<b>Profiles are cleverly matched:</b>
<li> Same geographic area as the user.</li>
<li> With a maximum of common tags.</li>
<li> With a maximum “fame rating”.</li>
<li> You must show in priority people from the same geographical area.</li>
<li> The list must be sortable by age, localization, “fame rating” and common tags.</li>
<li> The list must be filterable by age, localization, “fame rating” and common tags.</li>
</ul>

<ul><b>Research:</b><br>
The user is able to run an advanced research selecting one or a few criterias such
as:
<li> A age gap.</li>
<li> A “fame rating” gap.</li>
<li> A location.</li>
<li> One or multiple interests tags.</li>
</ul>

<ul><b>Profile of other users</b><br>
The user also is able to:
<li> If he has at least one picture “like” another user. When two people “like” each other,
we will say that they are “connected” and are now able to chat. If the current user
does not have a picture, he/she cannot complete this action.</li>
<li> Check the “fame rating”.</li>
<li> See if the user is online, and if not see the date and time of the last connection.</li>
<li> Report the user as a “fake account”.</li>
<li> Block the user. A blocked user won’t appear anymore in the research results and
won’t generate additional notifications.</li>
<li>A user can clearly see if the consulted profile is connected or “like” his/her profile and
must be able to “unlike” or be disconnected from that profile.</li>
  </ul>
<ul><b>Chat</b><br>
When two users are connected, they are able to “chat” in real time(<b>WebSocket.io</b>).
  </ul>
  
<ul><b>Notifications:</b><br>
A user will be notified in real time of the following events:
<li> The user received a “like”.</li>
<li> The user’s profile has been checked.</li>
<li> The user received a message.</li>
<li> A “liked” user “liked” back.</li>
<li> A connected user “unliked” you.</li>
<li>A user is able to see, from any page that a notification hasn’t been read.</li>
</ul>
