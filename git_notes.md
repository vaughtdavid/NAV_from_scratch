# WORKING WITH GIT/GITHUB
**Notes from [this video](https://www.youtube.com/watch?time_continue=1859&v=ZDR433b0HJY) by Scott Chacon of GitHub**

## SETUP
git config --global user.name "your name here"
git config --global user.email "your email here"
git config --global color.ui true

## GETTING STARTED
### Create a new repository on the command line
- echo "# NAV_from_scratch" >> README.md
- git init
- git add README.md
- git commit -m "first commit"
- git remote add origin https://github.com/vaughtdavid/NAV_from_scratch.git
- git push -u origin master

### …or push an existing repository from the command line
- git remote add origin https://github.com/vaughtdavid/NAV_from_scratch.git
- git push -u origin master


## COMMANDS
- git init 	
	- will create an empty Git repository in the current directory or a directory you specify. 
- git clone	
	- Work on an existing repository that lives at a remote location
	- *git clone git://github.com/vaughtdavid/Hello-World.git*
- git pull	
	- To make sure you have the latest version of the repository (if you cloned from a remote, upstream location)
	- *git pull origin quandl*
- edit the files..
- git add		
	- After adding new files or making changes to existing ones, add your changes.
	- *git add .*
- git commit	
	- Commit and describe your changes.
	- *git commit -a*
		- adds all changes and commits
	- *git commit -m "message goes here."*
- git push	
	- Send your changes to a remote location, such as GitHub.
- git st		
	- status
- git checkout -- .
	- Discard uncomitted changes. 

## ADDITIONAL NOTES
- git branch blue			
	- make branch blue
- git checkout blue		
	- checkout existing branch
- git checkout -b blue	
	- makes and checks out
- *(git stash cleans out working directory)*
- git branch
	- shows current branch

## GRAPHING BRANCHES
- Aliases stolen from [this StackOverflow answer](https://stackoverflow.com/questions/1057564/pretty-git-branch-graphs).
	- git lg1
	- git lg2
	- git lg3

## MERGING MULTIPLE BRANCHES
### Check out [this tutorial](https://git-scm.com/book/en/v2/Git-Branching-Basic-Branching-and-Merging)!
- git checkout master
- git merge email
- git merge blue
- **now master reflects the changes in the email branch and the blue branch.**

