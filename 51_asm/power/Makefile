FILE := power

default: build run


compile:
	@echo "Compile  $(FILE)..."
	nasm -felf64    $(FILE).asm
	
link:
	@echo "Link     $(FILE)..."
	ld -o $(FILE)   $(FILE).o 

gcc:
	gcc -o $(FILE)  $(FILE).o

run:
	@echo "Run      $(FILE)..."
	./$(FILE)


clean:
	rm *.o *.out $(FILE)

build: compile gcc
	

