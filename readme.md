# HeavyD - Dev suite

Contains a single point to develop all the different heavyd packages.
Ensuring easy access to all the components and ensuring that every 
change validates the new functionality vs all the different items.

## src 
The source folder contains all the basic items that make up the full 
workflow suite. 
This comprises of the following items:

### Components 
Small stand alone helper classes etc. Which are used by both the seeder
the global cli and the actual platform.

### Project
The core versionable package that is implemented into every one of the 
workflow packages. Contains the project centric logic that versions 
as a dependency. 

### Global
The global CLI application that can be added to a local dev's 
environment to make it easier to detect various heavyd commands etc. 

### Seeder
The seeder that assembles new projects based on a configuration file
ensuring that every project is created equally. 


