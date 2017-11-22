import os
import pymysql
from threading import Thread
from time import sleep

conn = pymysql.connect(host="localhost", user="testoj", password="Testoj1111!", db="testoj", charset="utf8", autocommit=True)

lastjudged = 0;

def judge(lang, problemid, submitid):
	conn = pymysql.connect(host="localhost", user="testoj", password="Testoj1111!", db="testoj", charset="utf8", autocommit=True)
	with conn.cursor(pymysql.cursors.DictCursor) as cursor:
		workdir = "/home/judge/problem/" + problemid + "/submit/" + submitid + "/"
		judgedir = "/home/judge/judge/"
		if lang == u"C":
			workdir = workdir + "Main.c"
			judgedir = judgedir + "C/"
		else:
			pass
			#error&die
		compileresult = os.system(judgedir + "compile " + problemid + " " + submitid)
		if compileresult != 0:
		

with conn.cursor(pymysql.cursors.DictCursor) as cursor:
	sql = "select submit_id, state, problem_id, language from submit where submit_id>%s order by submit_id asc"
	cursor.execute(sql, (lastjudged,))
	result = cursor.fetchall()
	for row in result:
		if row['state'] == u"pending":
			

