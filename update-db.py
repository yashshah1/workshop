import sys
try:
	n = int(sys.argv[1])
except:
	n = 10
q = "INSERT INTO `tasks` (`id`, `task`, `status`) VALUES (NULL, 'test-task-{}', '0');"
for i in range(n):
	print(q.format(i + 1))