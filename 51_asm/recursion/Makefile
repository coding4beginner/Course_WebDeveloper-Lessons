FILE := factorial

default:
	cat Makefile

compile:
	@echo "Compile  $(FILE)..."
	nasm -felf64    $(FILE).asm

link:
	gcc -std=c99 $(FILE).o main.c -o main

run:
	@echo "Run      $(FILE)..."
	./$(FILE)


clean:
	rm *.o *.out $(FILE)

build: compile link
	#

