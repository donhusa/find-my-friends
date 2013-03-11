
Notes:

PHP errors turned off for production
3 batches of 25 friends used (rather than all friends)
	full friend query takes ~45 seconds
all advanced permissions (e.g. education, location info) have been removed for production
	see index.php -> data-scope


Ideas:

lots of mutual friends - proably same school
few mutual friends - more likely to have met in a group / event


TODO:

fix authorization - not all data is used
get user's picture to go along with name

status_feed_parser - should be used to find seed friends
	(friend groups that don't interact aren't helpful)


link to overlap to actually see friends
use pictures of friends to show friend groups
animate friend groups

TO LEARN: 

learn how to use test users
log in as an app
use app analytics

ABOUT:

aggregation: Person FOUND a FRIEND GROUP on FIND MY FRIENDS
see which friends have: same education, hometown, work, likes, groups
bond over sports, interests
agree upon values

misc FB notes:

authentication (login)
authorization (allow app to access data (if first time) / access token)
	-get status knows both 
