import pymysql
import sys
try:
	n = int(sys.argv[1])
except:
	n = 10
# Open database connection
db = pymysql.connect("localhost","yash","password","workshop" )

# prepare a cursor object using cursor() method
cursor = db.cursor()

q = "INSERT INTO `tasks` (`id`, `task`, `status`) VALUES (NULL, 'test-task-{}', '0');"
for i in range(n):
	print(q.format(i + 1))
	cursor.execute(q.format(i + 1))


# disconnect from server
db.close()