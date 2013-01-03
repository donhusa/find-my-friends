
Notes:

PHP errors turned off for production
there are all kinds of global variables flying around...
3 batches of 25 friends used (rather than all friends)
	full friend query takes ~45 seconds
all advanced permissions (e.g. education, location info) have been removed for production
	see index.php -> data-scope


TODO:

status_feed_parser - should be used to find seed friends
	(friend groups that don't interact aren't helpful)

lots of mutual friends - proably same school
few mutual friends - more likely to have met in a group / event

link to overlap to actually see friends
use pictures of friends to show friend groups
animate friend groups